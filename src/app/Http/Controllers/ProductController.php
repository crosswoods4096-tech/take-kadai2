<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔍 キーワード検索（商品名）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // 💴 価格順ソート
        if ($request->sort === 'low') {
            $query->orderBy('price', 'asc');   // 安い順
        } elseif ($request->sort === 'high') {
            $query->orderBy('price', 'desc');  // 高い順
        }

        // ページネーション
        $products = $query->paginate(6)->appends($request->query());

        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.create');
    }
}
