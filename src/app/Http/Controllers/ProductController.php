<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(6); // 1ページ6件など

        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.create');
    }
}
