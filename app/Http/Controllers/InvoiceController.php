<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    
   
    public function show($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        return view('pages.invoice.invoice', compact('order'));
    }
   
    public function downloadInvoice($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        $pdf = Pdf::loadView('pages.invoice.download', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');

    }
}