<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    public function index()
    {
        //all orders
        $orders = \App\Models\Order::with('customers', 'orderItems',  'product', 'orderItems.product')->orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Order',
            'data' => $orders
        ], 200);
    }

    public function generateReceiptNo($transaction_time)
    {
        $fileName = date("Ymd") . '-';
        $countTransaction = DB::select('CALL getMaxTransactionMonth(?)', [$transaction_time]);
        // Ambil nilai pertama dari hasil query (asumsi hasil query berupa objek stdclass)
        $countValue = reset($countTransaction)->counts;
        $result = $fileName . $countValue;
        return $result;
    }


    public function getOrderByStatus($status)
    {
        $orders = \App\Models\Order::with('customers', 'orderItems', 'product', 'orderItems.product')
            ->where('status', $status)
            ->where('status_payment', 'paid')
            ->orderBy('id', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No orders found with the specified criteria',
                'data' => []
                // ], 404); // Menggunakan status 404 Not Found untuk menunjukkan bahwa data tidak ditemukan
            ], 200);
        }


        return response()->json([
            'success' => true,
            'message' => 'List Data Order',
            'data' => $orders
        ], 200);
    }

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
        $receiptNo = $this->generateReceiptNo($data['transaction_time']);

        // Membuat pesanan
        // $order = Order::create([
        $order = \App\Models\Order::create([
            'transaction_time' => $data['transaction_time'],
            'total_price' => $data['total_price'],
            'total_quantity' => $data['total_quantity'],
            'payment_method' => $data['payment_method'],
            'customer_id' => $data['customer_id'],
            'amount_payment' => $data['amount_payment'],
            'amount_changes' => $data['amount_changes'],
            'status' => $data['status'],
            'status_payment' => $data['status_payment'],
            'cashier_id' => $data['cashier_id'],
            'is_sync' => $data['is_sync'],
            'cashier_name' => $data['cashier_name'],
            'receipt_no' => $receiptNo,
            'queue_on' => $data['transaction_time'],
            'queue_by' => $data['cashier_id'],
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

        if ($order) {
            $orderItems = $data['order_items'];
            return response()->json([
                'success' => true,
                'message' => 'Order Created',
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

    public function updateStatusOrder(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:queue,processed,completed,canceled',
            ]);

            $order = \App\Models\Order::findOrFail($id);

            // Define the fields and values based on the status
            $statusFields = [
                'queue' => ['status', 'queue_on', 'queue_by'],
                'processed' => ['status', 'processed_on', 'processed_by'],
                'completed' => ['status', 'completed_on', 'completed_by'],
                'canceled' => ['status', 'canceled_on', 'canceled_by'],
            ];

            // Set the fields and values based on the status
            if (isset($statusFields[$request->input('status')])) {
                $fieldsToUpdate = $statusFields[$request->input('status')];
                $updateData = array_combine($fieldsToUpdate, [$request->input('status'), now(), $request->input('update_by')]);
                $order->update($updateData);
            } else {
                // Handle other status values or provide an error message
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status provided.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => $order,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }
    }


    // public function updateStatusOrder(Request $request, $id)
    // {
    //     try
    //     {
    //         $request->validate([
    //             'status' => 'required|in:queque,processed,completed,canceled',
    //         ]);

    //         $order = \App\Models\Order::findOrFail($id);
    //         $order->update(['status' => $request->input('status')]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Status updated successfully',
    //             'data' => $order,
    //         ]);

    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Order not found.',
    //         ], 404);
    //     }
    // }
}
