<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm($id)
    {
        $order = Order::with('items.menu', 'table')->findOrFail($id);

        if ($order->status === 'dibayar') {
            return redirect()->route('orders.show', $id)->with('success', 'Pesanan sudah dibayar.');
        }

        return view('orders.payments', compact('order'));
    }

    /**
     * Handle the payment for an order.
     */

    public function pay(Request $request, $id)
    {
        $order = Order::with('items', 'table')->findOrFail($id);
        $total = $order->items->sum('subtotal');

        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $total],
            'payment_method' => ['required', 'in:tunai,qris,debit,kredit'],
        ]);

        $amount = $request->amount;
        $change = $amount - $total;

        // Simpan data pembayaran
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->amount = $request->amount;
        $payment->change = $request->amount - $total;
        $payment->method = $request->payment_method;
        $payment->user_id = Auth::id();
        $payment->save();

        // Update status pesanan dan meja
        $order->status = 'dibayar';
        $order->save();

        $order->table->update(['status' => 'kosong']);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil!');
    }





    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
