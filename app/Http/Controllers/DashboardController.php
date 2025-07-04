<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah pesanan hari ini
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Jumlah pesanan bulan ini
        $monthlyOrders = Order::whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year)
                              ->count();

        // Total pendapatan hari ini
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
                            ->where('status', 'dibayar')
                            ->with('items')
                            ->get()
                            ->sum(function ($order) {
                                return $order->items->sum('subtotal');
                            });

        // Total pendapatan bulan ini
        $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year)
                              ->where('status', 'dibayar')
                              ->with('items')
                              ->get()
                              ->sum(function ($order) {
                                  return $order->items->sum('subtotal');
                              });

        // Total keseluruhan
        $totalRevenue = Order::where('status', 'dibayar')->with('items')->get()
            ->sum(function ($order) {
                return $order->items->sum('subtotal');
            });

        // Generate 7 hari terakhir
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        // Ambil data pesanan
        $rawData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('date')
            ->pluck('total', 'date');

        // Isi data kosong dengan nol
        $ordersPerDay = $dates->map(function ($date) use ($rawData) {
            return [
                'date' => Carbon::parse($date)->translatedFormat('D, d M'),
                'total' => $rawData[$date] ?? 0
            ];
        });

        // 5 pesanan terbaru
        $recentOrders = Order::with('table', 'user')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'todayOrders',
            'monthlyOrders',
            'todayRevenue',
            'monthlyRevenue',
            'totalRevenue',
            'ordersPerDay',
            'recentOrders'
        ));
    }
}
