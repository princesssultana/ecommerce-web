<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
   {
        $allCustomers = Customer::latest()->get();
        return view('pages.customer.index', compact('allCustomers'));
    }
    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        return view('pages.customer.create');
    }

    public function store(Request $request)
    {
        Customer::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'city'    => $request->city,
            
            'status'  => $request->status,
        ]);

       // notify()->success('⚡️ Customer Created Successfully.');
        return redirect()->route('customers.index');
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if(!$customer){
            notify()->error('Customer not found!');
            return redirect()->route('customers.index');
        }

        return view('pages.customer.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        if(!$customer){
            notify()->error('Customer not found!');
            return redirect()->route('customers.index');
        }

        return view('pages.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if(!$customer){
            notify()->error('Customer not found!');
            return redirect()->back();
        }

        $customer->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'city'    => $request->city,
            
            'status'  => $request->status,
        ]);

        notify()->success('⚡️ Customer Updated Successfully.');
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        if(!$customer){
            notify()->error('Customer not found!');
            return redirect()->back();
        }

        $customer->delete();

        notify()->success('⚡️ Customer Deleted Successfully.');
        return redirect()->route('customers.index');
    }
}
