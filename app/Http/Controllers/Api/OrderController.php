<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //store order and order item
    // public function store(Request $request)
    // {
    //     //validate
    //     $request->validate([
    //         'transaction_time' => 'required',
    //         // 'kasir_id' => 'required|exists:users,id',
    //         'total_price' => 'required|numeric',
    //         'total_quantity' => 'required|numeric',
    //         'payment_method' => 'required|string',
    //         'customer_id' => 'required|numeric',
    //         'amount_payment' => 'required|numeric',
    //         'cashier_id' => 'required|numeric',
    //         'is_sync' => 'required|numeric',
    //         'cashier_name' => 'required|string',
    //         'order_items' => 'required|array',
    //         'order_items.*.product_id' => 'required|exists:products,id',
    //         'order_items.*.quantity' => 'required|numeric',
    //         // 'order_items.*.total_price' => 'required|numeric',
    //         'order_items.*.product' => 'required|json',
    //     ]);

    //     //create order
    //     $order = \App\Models\Order::create([
    //         'transaction_time' => $request->transaction_time,
    //         'total_price' => $request->total_price,
    //         'total_quantity' => $request->total_quantity,
    //         'kasir_id' => $request->kasir_id,
    //         'payment_method' => $request->payment_method,
    //         'customer_id' => $request->customer_id,
    //         'amount_payment' => $request->amount_payment,
    //         'cashier_id' => $request->cashier_id,
    //         'is_sync' => $request->is_sync,
    //         'cashier_name' => $request->cashier_name,
    //         'order_items' => $request->order_items,
    //     ]);

    //     //create order item
    //     foreach ($request->order_items as $item) {
    //         \App\Models\OrderItem::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item['product_id'],
    //             'quantity' => $item['quantity'],
    //             'product' => $item['product'],
    //             // 'total_price' => $item['total_price'],

    //         ]);
    //     }

    //     //response
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Order Created'
    //     ], 201);
    // }

    // new
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'transaction_time' => 'required',
            'total_price' => 'required|numeric',
            'total_quantity' => 'required|numeric',
            'payment_method' => 'required|string',
            'customer_id' => 'required|numeric',
            'amount_payment' => 'required|numeric',
            'cashier_id' => 'required|numeric',
            'is_sync' => 'required|boolean',
            'cashier_name' => 'required|string',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            // 'order_items.*.product' => 'required|json',
        ]);

        // Mendapatkan data JSON dari request
        $data = $request->json()->all();

        // Membuat pesanan
        // $order = Order::create([
        $order = \App\Models\Order::create([
            'transaction_time' => $data['transaction_time'],
            'total_price' => $data['total_price'],
            'total_quantity' => $data['total_quantity'],
            'payment_method' => $data['payment_method'],
            'customer_id' => $data['customer_id'],
            'amount_payment' => $data['amount_payment'],
            'cashier_id' => $data['cashier_id'],
            'is_sync' => $data['is_sync'],
            'cashier_name' => $data['cashier_name'],
        ]);

        // Membuat item pesanan
        foreach ($data['order_items'] as $item) {
            // OrderItem::create([
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                // 'product' => json_decode($item['product'], true), // Decode string JSON menjadi array
                // 'product' => $item['product'], // Decode string JSON menjadi array
                // 'product' => json_encode($item['product']), // Mengonversi array menjadi string JSON
            ]);
        }

        // Respon JSON
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Order Created'
        // ], 201);
        if ($order) {
            // $orderItems = $order->orderItems;
            $orderItems = $data['order_items'];
            return response()->json([
                'success' => true,
                'message' => 'Order Created',
                // 'data' => $order
                'data' => [
                    'order' => $order,
                    'order_items' => $orderItems
                ]
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Order Failed to Save',
            ], 409);
        }
    }
}
