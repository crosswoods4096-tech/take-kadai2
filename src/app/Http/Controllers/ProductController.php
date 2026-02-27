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
            $query->where('name', 'like', '%' . $request->keyword . '%');
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
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    public function store(Request $request)
    {
        // バリデーション（画像・説明文も必須）
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'image'       => 'required|image|max:2048',
            'description' => 'required|string',
            'seasons'     => 'required|array',
            'seasons.*'   => 'integer|exists:seasons,id',
        ]);

        // 画像保存
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // 商品登録
        $product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'image'       => $validated['image'],
            'description' => $validated['description'],
        ]);

        // 季節の紐付け
        $product->seasons()->sync($validated['seasons']);

        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }

    public function show(Product $product)
    {
        $seasons = Season::all();
        $selectedSeasons = $product->seasons->pluck('id')->toArray();

        return view('products.show', compact('product', 'seasons', 'selectedSeasons'));
    }

    public function update(Request $request, Product $product)
    {
        // バリデーション（画像・説明文も必須に統一）
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer',
            'description' => 'required|string',
            'image'       => 'required|image|max:2048',
            'seasons'     => 'required|array',
            'seasons.*'   => 'integer|exists:seasons,id',
        ]);

        // 画像差し替え
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // 商品情報更新
        $product->update([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'image'       => $validated['image'],
            'description' => $validated['description'],
        ]);

        // 季節の中間テーブル更新
        $product->seasons()->sync($validated['seasons']);

        return redirect()->route('products.show', $product->id)
            ->with('success', '商品情報を更新しました');
    }
}
