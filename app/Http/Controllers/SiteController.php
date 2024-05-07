<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

class SiteController extends Controller
{
    public function index()
    {
        $data = Product::latest()->paginate(20);
        return view('product.index', compact('data'));
    }

    public function order()
    {
        $data = Order::latest()->paginate(20);
        return view('order.index', compact('data'));
    }

    public function search(Request $request)
    {
        $query = Order::query();

        if (request('search')) {
            $query->whereDate('created_at', 'like', '%' . request('search') . '%');
        }
        $data = $query->paginate(10);

        return view('order.index', compact('data'));
    }
}
