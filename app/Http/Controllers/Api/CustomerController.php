<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        //all products
        $customers = \App\Models\Customers::orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $customers
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $customer = \App\Models\Customers::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'Customer created',
                'data' => $customer
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Customer failed to save',
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}