<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        //get data customers
        $customers = DB::table('customers')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(Request $request)
    {
        $user = \App\Models\Customers::where('name', $request->name)->first();
        if ($user) {
            return response([
                'message' => ['Email Already Exists'],
            ], 303);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);


        $data = $request->all();
        $customer = new \App\Models\Customers;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customers successfully created');
    }

    public function edit($id)
    {
        $customer = \App\Models\Customers::findOrFail($id);
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $customer = \App\Models\Customers::findOrFail($id);
        $customer->update($data);
        return redirect()->route('customer.index')->with('success', 'Customer successfully updated');
    }

    public function destroy($id)
    {
        $customer = \App\Models\Customers::findOrFail($id);
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'Customer successfully deleted');
    }
}