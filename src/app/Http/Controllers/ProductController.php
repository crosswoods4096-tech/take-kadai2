<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Season;

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
    public function show(Product $product)
    {
        $seasons = Season::all();
        $selectedSeasons = $product->seasons->pluck('id')->toArray();

        return view('products.show', compact('product', 'seasons', 'selectedSeasons'));
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'season' => 'array',
        ]);

        // 画像差し替え
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // 商品情報更新
        $product->update($validated);

        // 季節の中間テーブル更新
        $product->seasons()->sync($request->season ?? []);

        return redirect()->route('products.show', $product->id)
            ->with('success', '商品情報を更新しました');
    }
}
