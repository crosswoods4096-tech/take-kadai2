@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 見出し -->
    <h1 class="mb-4 fw-bold">商品一覧</h1>

    <!-- 上部操作エリア -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <!-- 検索フォーム -->
        <form action="{{ route('products.index') }}" method="GET" class="d-flex" style="gap: 8px;">
            <input type="text" name="keyword" class="form-control" placeholder="商品名で検索">
            <button class="btn btn-primary">検索</button>
        </form>

        <!-- 並び替え -->
        <form action="{{ route('products.index') }}" method="GET">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="">価格順で表示</option>
                <option value="low">価格で安い順</option>
                <option value="high">価格で高い順</option>
            </select>
        </form>

    </div>

    <!-- 商品一覧グリッド -->
    <div class="row g-4">

        @foreach ($products as $product)
        <div class="col-md-4 col-lg-3">

            <div class="card shadow-sm position-relative" style="overflow: hidden;">

                <!-- 商品画像 -->
                <img src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    style="width: 100%; height: 250px; object-fit: cover;">

                <!-- 商品名（左下） -->
                <div style="
                    position: absolute;
                    bottom: 10px;
                    left: 10px;
                    color: white;
                    font-size: 20px;
                    font-weight: bold;
                    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
                ">
                    {{ $product->name }}
                </div>

                <!-- 価格（右下） -->
                <div style="
                    position: absolute;
                    bottom: 10px;
                    right: 10px;
                    color: white;
                    font-size: 20px;
                    font-weight: bold;
                    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
                ">
                    ¥{{ number_format($product->price) }}
                </div>

            </div>

        </div>
        @endforeach

    </div>

    <!-- ページネーション -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>

</div>
@endsection