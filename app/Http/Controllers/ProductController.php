<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        return view('product.create');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_unit' => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tax' => 'nullable|numeric|min:0|max:100',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pro = new Product();
        $pro->product_name = $request->product_name;
        $pro->variants = json_encode($request->variants);
        $pro->product_sku = $request->product_sku ;
        $pro->product_unit = $request->product_unit;
        $pro->product_unit_value = $request->product_unit_value;
        $pro->selling_price = $request->selling_price;
        $pro->purchase_price = $request->purchase_price;
        $pro->discount = $request->discount;
        $pro->tax = $request->tax;

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $path = "uploads/product";
            $filename = uploadImage($file, $path, 'public', 'public');

            if ($filename) {
                // Image uploaded successfully
                $pro->product_image = $path . '/' . $filename;
            } else {
                // Error uploading image
                Session::flash('error', 'Error uploading image');
                return back();
            }
        } else {
            Session::flash('error', 'No image file uploaded');
            return back();
        }

        $pro->save();
        Session::flash('success', 'Product Store successfully');
        return back();

    }

    public function edit($id)
    {
        $pro = Product::find($id);
        $variants = json_decode($pro->variants, true);
        //dd($variants);
        return view('product.edit',compact('pro','variants'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_unit' => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tax' => 'nullable|numeric|min:0|max:100',
            //'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       //dd($request->product_image);

        $pro = Product::where('id',$id)->first();

        $pro->product_name = $request->product_name;
        $pro->variants = json_encode($request->variants);

        $pro->product_sku = $request->product_sku ;
        $pro->product_unit = $request->product_unit;
        $pro->product_unit_value = $request->product_unit_value;
        $pro->selling_price = $request->selling_price;
        $pro->purchase_price = $request->purchase_price;
        $pro->discount = $request->discount;
        $pro->tax = $request->tax;
        //dd($request->product_image);
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $path = "uploads/product";
            $filename = uploadImage($file, $path, 'public', 'public');

            if ($filename) {
                // Image uploaded successfully
                $pro->product_image =  $path . '/' . $filename;
            } else {
                // Error uploading image
                Session::flash('error', 'Error uploading image');
                return back();
            }
        }

        $pro->save();
        Session::flash('success', 'Product Edit successfully');
        return back();
    }

    public function delete($id)
    {

    }
}
