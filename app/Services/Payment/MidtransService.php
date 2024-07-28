<?php

namespace App\Services\Payment;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{


    public function __construct()
    {
        if (!app()->runningInConsole()) {
            $this->loadConfig();
        } else if (app()->runningInConsole() && app()->runningUnitTests()) {
            $this->loadConfig();
        }
    }

    public function loadConfig()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('APP_ENV') == 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    /**
     * MidtransGateway constructor
     * Place configuration initialization here
     */
    /**
     * Create transaction
     *
     * @param PaymentChannel $paymentChannel
     * @return mixed
     */
    public function CreateTransaction(mixed $user_id, mixed $order_id, array $addresses): mixed
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($order_id);
            $orderDetails = OrderDetail::where('id_order', $order_id)->with(['product'])->get();
            $customerDetail = Customer::findOrFail($user_id);

            // Create transaction payload
            $payload['transaction_details'] = $this->generateTransactionDetails($order_id, $order->grand_total);
            $payload['item_details'] = $orderDetails->map(function ($item) {
                return [
                    'id' => $item->id_produk,
                    'price' => $item->product->harga,
                    'quantity' => $item->jumlah,
                    'name' => $item->product->nama_produk,
                ];
            })->toArray();
            $payload['customer_details'] = $this->generateCustomerDetails($customerDetail);
            // Generate Snap Token
            $response = Snap::createTransaction($payload);

            Payment::create([
                'id_order' => $order_id,
                'jumlah' => $order->grand_total,
                'provinsi' => $addresses["provinsi"],
                'kabupaten' => $addresses["kabupaten"],
                'id_customer' => $user_id,
                'snap_token' => $response->token,
                'kecamatan' => "",
                'detail_alamat' => $addresses["detail"],
                'status' => 'MENUNGGU',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            return [
                'snap_token' => null,
                'redirect_url' => null
            ];
        }
        return [
            'snap_token' => $response->token,
            'redirect_url' => $response->redirect_url
        ];
    }

    // /**
    //  * Get transaction status
    //  *
    //  * @param Pembayaran $pembayaran
    //  * @return Pembayaran|null
    //  */
    // public function GetTransactionStatus(Payment $payment): ?Payment
    // {
    //     try {
    //         $status = Transaction::status($pembayaran->trx_id);

    //         $pembayaran->logs()->create([
    //             'payload' => json_encode($status),
    //         ]);

    //         $kode = $pembayaran->channel->kode;

    //         $va_number = match ($kode) {
    //             'echannel' => $status->bill_key . '-' . $status->biller_code,
    //             'permata_va' => $status->permata_va_number,
    //             'bni_va', 'bca_va', 'bri_va' => $status->va_numbers[0]->va_number,
    //             'alfamart', 'indomaret' => $status->payment_code,
    //             default => null,
    //         };

    //         $status_pembayaran = match ($status->transaction_status) {
    //             'settlement' => 'lunas',
    //             'expire' => 'expired',
    //             'deny', 'cancel' => 'batal',
    //             default => 'belum lunas',
    //         };

    //         $tanggal_pembayaran = $status_pembayaran == 'lunas' ? now() : null;

    //         $pembayaran->update([
    //             'status' => $status_pembayaran,
    //             'virtual_account' => $va_number ?? null,
    //             'tanggal_expired' => $status->expiry_time,
    //             'tanggal_pembayaran' => $tanggal_pembayaran,
    //             'sisa_tagihan' => $status_pembayaran == 'lunas' ? 0 : $pembayaran->nominal - $status->gross_amount,
    //         ]);

    //         if (!$pembayaran->histories()->where('status', $status_pembayaran)->first()) {
    //             $pembayaran->histories()->create([
    //                 'nominal' => $status_pembayaran == 'lunas' ? $status->gross_amount : 0,
    //                 'status' => $status_pembayaran,
    //                 'keterangan' => $status->status_message ?? null,
    //                 'tanggal_pembayaran' => now(),
    //                 'payload' => json_encode($status),
    //             ]);
    //         }
    //     } catch (\Throwable $e) {
    //         return $pembayaran;
    //     }

    //     return $pembayaran;
    // }

    /**
     * Callback function
     *
     * @param Request $request
     * @return mixed
     */
    public function Callback(Request $request): mixed
    {
        $data = $request->all();
        if (!isset($data['order_id'])) {
            return response()->json("order_id is required", 400);
        }

        $pembayaran = Payment::where('id_order', $data['order_id'])->first();
        if (!$pembayaran) {
            return response()->json("Order not found", 404);
        }

        try {
            // Verify Midtrans Signature
            $expected_signature = hash('sha512', $data['order_id'] . $data['status_code'] . $data['gross_amount'] . env('MIDTRANS_SERVER_KEY'));
            if ($data['signature_key'] != $expected_signature) {
                return response()->json("Invalid signature", 400);
            }
            // Update Pembayaran Status
            DB::beginTransaction();
            try {

                $status = match ($data['transaction_status']) {
                    'settlement' => 'LUNAS',
                    'expire' => 'EXPIRED',
                    'deny', 'cancel' => 'BATAL',
                    default => 'MENUNGGU',
                };

                $pembayaran->update([
                    'status' => $status,
                    'updated_at' =>  now(),
                ]);

                if ($status == 'LUNAS') {
                    $order = Order::findOrFail($data['order_id']);
                    $order->update([
                        'status' => 'LUNAS',
                        'updated_at' => now(),
                    ]);
                }
                DB::commit();
            } catch (\Throwable) {
                DB::rollBack();
                return response()->json("Failed to update payment status", 500);
            }
        } catch (\Throwable) {
            return response()->json("Invalid signature", 400);
        }
        return response()->json("Payment status updated", 200);
    }

    /**
     * Generate Transaction Details Payload
     *
     * @param string $orderId Order ID
     * @param int $total Total Amount
     * @return array
     */
    private function generateTransactionDetails(string $orderId, int $total): array
    {
        return [
            'order_id' => $orderId,
            'gross_amount' => $total
        ];
    }

    /**
     * Generate Customer Details Payload
     *
     * @param object $register Register
     * @return array
     */
    private function generateCustomerDetails(object $customer): array
    {
        return [
            'first_name' => $customer->nama_customer,
            'email' => $customer->email,
            'phone' => $customer->no_hp,
        ];
    }
}
