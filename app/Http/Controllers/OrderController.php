<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // সব orders দেখাও
    public function index()
    {
        $allOrders = Order::with('user')->latest()->get();
        return view('pages.orders.index', compact('allOrders'));
    }

    // একটা order এর details
    public function show($id)
    {
        $order = Order::with('items.product', 'user')->find($id);

        if(!$order){
            notify()->error('Order not found!');
            return redirect()->route('orders.index');
        }

        return view('pages.orders.show', compact('order'));
    }

    // Status update form
    public function edit($id)
    {
        $order = Order::find($id);

        if(!$order){
            notify()->error('Order not found!');
            return redirect()->route('orders.index');
        }

        return view('pages.orders.edit', compact('order'));
    }

    // Status update save
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if(!$order){
            notify()->error('Order not found!');
            return redirect()->back();
        }

        $order->update([
            'status' => $request->status
        ]);

        //notify()->success('⚡️ Order Status Updated Successfully.');
        return redirect()->route('orders.index');
    }

    // Order delete
    public function destroy($id)
    {
        $order = Order::find($id);

        if(!$order){
            notify()->error('Order not found!');
            return redirect()->back();
        }

        $order->delete();

        //notify()->success('⚡️ Order Deleted Successfully.');
        return redirect()->route('orders.index');
    }
}