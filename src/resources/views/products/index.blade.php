@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 見出し -->
    <h1 class="mb-4 fw-bold">商品一覧</h1>

    <!-- 上部：商品登録ボタン（右上） -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">
            ＋ 商品を登録
        </a>
    </div>

    <!-- 2カラム構成 -->
    <div class="row">

        <!-- 左カラム：検索 + 並び替え -->
        <div class="col-md-3 mb-4">

            <!-- 検索フォーム -->
            <form action="{{ route('products.index') }}" method="GET" class="mb-3">
                <label class="form-label fw-bold">商品名で検索</label>
                <input type="text" name="keyword" class="form-control"
                    value="{{ request('keyword') }}" placeholder="キーワードを入力">
                <button class="btn btn-primary w-100 mt-2">検索</button>
            </form>

            <!-- 並び替え -->
            <form action="{{ route('products.index') }}" method="GET">
                <label class="form-label fw-bold">並び替え</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">選択してください</option>
                    <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>価格が安い順</option>
                    <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>価格が高い順</option>
                </select>

                <!-- 検索キーワードを保持 -->
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            </form>

        </div>

        <!-- 右カラム：商品カード一覧 -->
        <div class="col-md-9">

            <div class="row g-4">
                @foreach ($products as $product)
                <div class="col-md-6 col-lg-4">

                    <!-- カード全体をリンク化 -->
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">

                        <div class="card shadow-sm h-100">

                            <!-- 商品画像 -->
                            <img src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                style="width: 100%; height: 240px; object-fit: cover;">

                            <!-- 白い情報エリア -->
                            <div class="p-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fw-bold text-dark" style="font-size: 18px;">
                                        {{ $product->name }}
                                    </div>
                                    <div class="fw-bold text-dark" style="font-size: 18px;">
                                        ¥{{ number_format($product->price) }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </a>

                </div>
                @endforeach
            </div>

            <!-- ページネーション -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>

        </div>

    </div>

</div>
@endsection