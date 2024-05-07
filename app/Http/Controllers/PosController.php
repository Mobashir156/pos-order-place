<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve products based on search query
        $query = Product::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('product_name', 'like', "%$search%")->orWhere('product_sku', 'like', "%$search%");
        }
        $products = $query->paginate(10);

        if ($request->ajax()) {
            return view('main.partial.products', compact('products'));
        }

        return view('pos.index', compact('products'));
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $cart = session()->get('cart', []);

        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->product_name,
            'price' => $product->selling_price,
            'tax' => $product->tax ?? 0,
            'discount' => $product->discount ?? 0,
            'quantity' => isset($cart[$product->id]) ? $cart[$product->id]['quantity'] + 1 : 1,
        ];

        session()->put('cart', $cart);

        $cart = session()->get('cart', []);

        $subtotal = 0;
        $tax = 0;
        $discount = 0;
        $prodiscount = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $tax += $item['tax'];
            $discount += $item['discount'];
            $prodiscount += $item['discount'] * $item['quantity'];
        }
        $total = $subtotal + $tax - $discount;

        return response()->json([
            'cartItems' => array_values($cart),
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'tax' => number_format($tax, 2, '.', ''),
            'discount' => number_format($discount, 2, '.', ''),
            'prodiscount' => number_format($prodiscount, 2, '.', ''),
            'total' => number_format($total, 2, '.', ''),
        ]);
    }

    public function remove($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return response()->json(['cartItems' => array_values($cart),
            'message' => 'Product removed from cart successfully']);
        } else {
            return response()->json(['error' => 'Product not found in cart'], 404);
        }
    }

    public function submit()
    {
        $cart = Session::get('cart');

        foreach ($cart as $it) {
            //dd($it);
            $item = new Order();
            $item->product_id = $it['id'];
            $item->qty = $it['quantity'];
            $item->subtotal = $it['price'];
            $item->tax = $it['tax'];
            $item->discount = $it['discount'];
            $prt = $it['discount'] * $it['quantity'];
            $total = $it['price'] - $prt + $it['tax'];
            $item->total = $total * $it['quantity'];
            $item->save();
        }
        Session()->forget('cart');
        return back();
    }
}
