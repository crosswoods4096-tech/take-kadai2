@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 見出し -->
    <h1 class="mb-4 fw-bold">商品一覧</h1>

    <!-- 上部操作エリア -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <!-- 検索フォーム -->
        <form action="{{ route('products.index') }}" method="GET" class="d-flex" style="gap: 8px;">
            <input type="text" name="keyword" class="form-control"
                placeholder="商品名で検索"
                value="{{ request('keyword') }}">
            <button class="btn btn-primary">検索</button>
        </form>

        <!-- 並び替えモーダルを開くボタン -->
        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#sortModal">
            並び替え
        </button>

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

<!-- ▼▼▼ 並び替えモーダル ▼▼▼ -->
<div class="modal fade" id="sortModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">並び替え条件</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('products.index') }}" method="GET">

                    <!-- 検索キーワードを保持 -->
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="low"
                            id="sortLow" {{ request('sort') === 'low' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sortLow">価格が安い順</label>
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="sort" value="high"
                            id="sortHigh" {{ request('sort') === 'high' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sortHigh">価格が高い順</label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary">適用</button>

                        <!-- 並び替えリセット（sort を空にして再検索） -->
                        <a href="{{ route('products.index', ['keyword' => request('keyword')]) }}"
                            class="btn btn-outline-danger">
                            リセット
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- ▲▲▲ 並び替えモーダル ▲▲▲ -->

@endsection