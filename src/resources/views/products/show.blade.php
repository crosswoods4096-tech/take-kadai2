@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- 戻るリンク -->
    <a href="{{ route('products.index') }}" class="text-decoration-none mb-3 d-inline-block">
        ← 商品一覧へ戻る
    </a>

    <div class="row">

        <!-- 左側：大きめの商品画像 -->
        <div class="col-md-6 mb-4">
            <img src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="img-fluid rounded shadow">
        </div>

        <!-- 右側：編集フォーム -->
        <div class="col-md-6">

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 商品名 -->
                <div class="mb-3">
                    <label class="form-label fw-bold">商品名</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $product->name) }}">
                </div>

                <!-- 値段 -->
                <div class="mb-3">
                    <label class="form-label fw-bold">値段</label>
                    <input type="number" name="price" class="form-control"
                        value="{{ old('price', $product->price) }}">
                </div>

                <!-- 季節（複数選択可） -->
                <div class="mb-3">
                    <label class="form-label fw-bold">旬の季節</label>
                    <div class="d-flex gap-3">
                        @foreach ($seasons as $season)
                        <label>
                            <input type="checkbox" name="season[]" value="{{ $season->id }}"
                                {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- 画像差し替え -->
                <div class="mb-3">
                    <label class="form-label fw-bold">画像を差し替える</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <!-- 説明文 -->
                <div class="mb-3">
                    <label class="form-label fw-bold">商品説明</label>
                    <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <button class="btn btn-success w-100">更新する</button>

            </form>

        </div>
    </div>

</div>
@endsection