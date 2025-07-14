<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;



class OrderController extends Controller
{
    
    public function index()
    {
       $ordersMenunggu = \App\Models\Order::with('table', 'user', 'items.menu')
        ->where('status', 'menunggu')
        ->orderBy('created_at', 'desc')
        ->get();

    $ordersDibayar = \App\Models\Order::with('table', 'user', 'items.menu')
        ->where('status', 'dibayar')
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
            'user_id' => Auth::id(), // atau auth()->id()
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





}
