<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Slider;
use App\Models\Product;
use App\Models\About;
use App\Models\Testimoni;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Order;
use App\Services\Payment\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $categories = Category::all();
        $testimonis = Testimoni::all();
        $products = Product::skip(0)->take(8)->get();

        return view('home.index', compact('sliders', 'categories', 'testimonis', 'products'));
    }
    public function products($id_subcategory)
    {
        $products = Product::where('id_subkategori', $id_subcategory)->get();

        return view('home.products', compact('products'));
    }

    public function add_to_cart(Request $request)
    {
        $input = $request->all();
        Cart::create($input);
    }

    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }

    public function product($id_product)
    {
        $product = Product::find($id_product);
        $latest_products = Product::orderByDesc('created_at')->offset(0)->limit(10)->get();

        return view('home.product', compact('product', 'latest_products'));
    }

    public function cart()
    {
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        // dd($response);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $provinsi = json_decode($response);
        $carts = Cart::where('id_customer',  Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->get();
        $cart_total = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->sum('total');

        return view('home.cart', compact('carts', 'provinsi', 'cart_total'));
    }

    public function get_kota($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function get_ongkir($destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=178&destination=" . $destination . "&weight=" . $weight . "&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function checkout_orders(Request $request)
    {
        $id = DB::table('orders')->insertGetId([
            'id_customer' => $request->id_customer,
            'invoice' => date('ymds'),
            'grand_total' => $request->grand_total,
            'status' => 'Baru',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        for ($i = 0; $i < count($request->id_produk); $i++) {
            DB::table('order_details')->insert([
                'id_order' => $id,
                'id_produk' => $request->id_produk[$i],
                'jumlah' => $request->jumlah[$i],
                'total' => $request->total[$i],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->update([
            'is_checkout' => 1
        ]);
    }

    public function checkout()
    {
        $about = About::first();
        $orders = Order::where('id_customer', Auth::guard('webcustomer')->user()->id)->latest("created_at")->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }


        $provinsi = json_decode($response);
        $midtrans_client_key = env('MIDTRANS_CLIENT_KEY');
        return view('home.checkout', compact('about', 'orders', 'provinsi',  'midtrans_client_key'));
    }


    public function payments(Request $request, MidtransService $midtransService)
    {

        try {
            $order_id = $request->id_order;
            $customerId = Auth::guard('webcustomer')->user()->id;

            $transaction = $midtransService->CreateTransaction($customerId, $order_id, [
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'detail' => $request->detail_alamat,
            ]);

            return response()->json($transaction);
        } catch (Throwable $err) {
            return response()->json([
                'message' => "Failed to create transaction". $err->getMessage(),
            ], 500);
        }


        // midtrans here
        // dd($request->all());


        // return redirect('/orders');
    }

    public function orders()
    {
        $orders = Order::where('id_customer', Auth::guard('webcustomer')->user()->id)->get();
        $payments = Payment::where('id_customer', Auth::guard('webcustomer')->user()->id)->get();
        return view('home.orders', compact('orders', 'payments'));
    }

    public function pesanan_selesai(Order $order)
    {
        $order->status = 'Selesai';
        $order->save();

        return redirect('/orders');
    }

    public function about()
    {
        $about = About::first();
        $testimonis = Testimoni::all();

        return view('home.about', compact('about', 'testimonis'));
    }

    public function contact()
    {
        $about = About::first();

        return view('home.contact', compact('about'));
    }

    public function faq()
    {
        return view('home.faq');
    }
}
