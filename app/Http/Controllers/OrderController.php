<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Payment;



class OrderController extends Controller
{

    public function index()
    {
        $ordersMenunggu = \App\Models\Order::with('table', 'user', 'items.menu')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        $today = Carbon::today();

        $ordersDibayar = \App\Models\Order::with('table', 'user', 'items.menu')
            ->where('status', 'dibayar')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'dibayar_page');

        return view('orders.index', compact('ordersMenunggu', 'ordersDibayar'));
    }

    // Form buat pesanan baru (pelayan/kasir)
    public function create()
    {
        $menus = Menu::all();
        $tables = Table::where('status', 'kosong')->get();

        return view('orders.create', compact('menus', 'tables'));
    }

    // Simpan pesanan ke database
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:revo_tables,id',
            'customer_name' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:revo_menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Simpan ke tabel orders
        $order = Order::create([
            'table_id' => $request->table_id,
            'customer_name' => $request->customer_name,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'status' => 'menunggu',
        ]);

        // Simpan setiap item menu
        foreach ($request->items as $item) {
            $menu = Menu::find($item['menu_id']);
            OrderItem::create([
                'order_id' => $order->id,

                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'subtotal' => $menu->price * $item['quantity'],
            ]);
        }

        // Update status meja jadi "dipesan"
        $order->table->update(['status' => 'terisi']);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil disimpan!');
    }

    // Tampilkan detail pesanan
    public function show(Order $order)
    {
        $order->load(['items.menu', 'user', 'table', 'payment']);
        return view('orders.show', compact('order'));
    }


    // Edit pesanan (opsional)
    public function edit($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        $menus = Menu::all();

        $tables = Table::where('status', 'kosong')
            ->orWhere('id', $order->table_id)
            ->get();

        return view('orders.edit', compact('order', 'menus', 'tables'));
    }


    public function update(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        $request->validate([
            'table_id' => 'required|exists:revo_tables,id',
            'customer_name' => 'required|string|max:100',
            'menu' => 'required|array|min:1',
            'menu.*' => 'nullable|integer|min:0'
        ]);

        $oldTableId = $order->table_id;

        // Update data order
        $order->update([
            'table_id' => $request->table_id,
            'customer_name' => $request->customer_name,
        ]);

        // Jika meja berubah, update status meja lama & baru
        if ($oldTableId != $request->table_id) {
            // Meja lama jadi kosong
            \App\Models\Table::where('id', $oldTableId)->update(['status' => 'kosong']);
            // Meja baru jadi terisi
            \App\Models\Table::where('id', $request->table_id)->update(['status' => 'terisi']);
        }

        // Update atau tambah item baru
        foreach ($request->menu as $menu_id => $qty) {
            $menu = Menu::find($menu_id);
            if (!$menu) continue;

            $existing = $order->items()->where('menu_id', $menu_id)->first();

            if ($qty > 0) {
                if ($existing) {
                    $existing->update([
                        'quantity' => $qty,
                        'subtotal' => $menu->price * $qty,
                    ]);
                } else {
                    $order->items()->create([
                        'menu_id' => $menu_id,
                        'quantity' => $qty,
                        'subtotal' => $menu->price * $qty,
                    ]);
                }
            } else {
                if ($existing) {
                    $existing->delete(); // hapus item dengan qty 0
                }
            }
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }



    // Hapus pesanan (jika dibatalkan)
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete();
        $order->delete();

        // Kembalikan status meja ke "kosong"
        $order->table->update(['status' => 'kosong']);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function history(Request $request)
    {
        $query = Order::with('table', 'user', 'items.menu', 'payment')
            ->where('status', 'dibayar');

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('orders.tableHistory', compact('orders'));
    }
    public function showHistory($id)
    {
        $order = Order::with('items.menu', 'table', 'user')->findOrFail($id);
        return view('orders.history-detail', compact('order'));
    }

    public function print($id)
    {
        $order = Order::with('items.menu', 'table', 'user')->findOrFail($id);
        return view('orders.print', compact('order'));
    }

    public function printHistory(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Order::with(['table', 'user', 'payment', 'items'])->where('status', 'dibayar');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $orders = $query->orderByDesc('created_at')->get();

        return view('orders.cetak', compact('orders', 'startDate', 'endDate'));
    }
}
