<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'working_time' => 'required|integer',
            'category' => 'required|in:satuan,kiloan',
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);

        // \App\Models\Product::create($data);
        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = (int) $request->price;
        $product->working_time = (int) $request->working_time;
        $product->category = $request->category;
        if ($request->hasFile('image')) {
            $filename = time(). '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $data = $request->all();
            $product->image = $filename;
        }
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();
    //     $product = \App\Models\Product::findOrFail($id);
    //     $product->update($data);
    //     return redirect()->route('product.index')->with('success', 'Product successfully updated');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'working_time' => 'required|integer',
            'category' => 'required|in:satuan,kiloan',
            'image' => 'image|mimes:png,jpg,jpeg'
        ]);


        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);


        if ($request->hasFile('image')) {
            // Delete the existing image file
            $imageOld = $product->image;
            Storage::delete('public/products/'.$imageOld);

            $filename = date("Ymd").time(). '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);

            // Update the model with the new file path
            $product->image = $filename;
        }
         // Update other fields
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->working_time = $request->input('working_time');
        $product->category = $request->input('category');
        $product->updated_at = date('Y-m-d H:i:s');

        // Save the model
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
