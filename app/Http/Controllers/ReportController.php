<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index']);
        $this->middleware('auth:api')->only(['get_reports']);
    }

public function get_reports(Request $request)
{
    $startDate = $request->input('dari');
    $endDate = $request->input('sampai');

    $report = DB::table('order_details')
        ->join('products', 'products.id', '=', 'order_details.id_produk')
        ->select(DB::raw('
            products.nama_produk,
            products.harga,
            SUM(order_details.jumlah) as jumlah_dibeli,
            SUM(order_details.total) as pendapatan,
            SUM(order_details.jumlah) as total_qty'))
        ->whereDate('order_details.created_at', '>=', $startDate)
        ->whereDate('order_details.created_at', '<=', $endDate)
        ->groupBy('products.id', 'products.nama_produk', 'products.harga')
        ->get();

    return response()->json([
        'data' => $report
    ]);
}

    public function index()
    {
        return view('report.index');
    }
}
