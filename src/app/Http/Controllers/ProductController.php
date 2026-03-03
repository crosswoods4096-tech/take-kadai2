<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Season;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

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
        $selectedSeasons = []; // 新規登録なので空

        return view('products.create', compact('seasons', 'selectedSeasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

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

    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $seasons = Season::all();

        // ★ ここが重要
        $selectedSeasons = $product->seasons->pluck('id')->toArray();

        return view('products.show', compact('product', 'seasons', 'selectedSeasons'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // 画像差し替え（先にやる）
        if ($request->hasFile('image')) {

            // 古い画像を削除
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }

            // 新しい画像を保存
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            // 画像を変更しない場合は元のまま
            $validated['image'] = $product->image;
        }

        // ここで初めて update
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

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 画像ファイル削除（存在する場合）
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        // 商品データ削除
        $product->delete();

        // 削除後は商品一覧へリダイレクト
        return redirect()->route('products.index')
            ->with('success', '商品を削除しました。');
    }
}
