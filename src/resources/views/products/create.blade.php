@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="mb-4 fw-bold">商品登録</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf

        {{-- 商品名 --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                商品名
                <span class="badge bg-danger ms-2">必須</span>
            </label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        @error('name')
        <div class="text-danger small">{{ $message }}</div>
        @enderror

        {{-- 値段 --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                値段（円）
                <span class="badge bg-danger ms-2">必須</span>
            </label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
        </div>
        @error('price')
        <div class="text-danger small">{{ $message }}</div>
        @enderror

        {{-- 商品画像 --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                商品画像
                <span class="badge bg-danger ms-2">必須</span>
            </label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        @error('image')
        <div class="text-danger small">{{ $message }}</div>
        @enderror

        {{-- 旬の季節 --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                旬の季節
                <span class="badge bg-danger ms-2">必須</span>
                <span style="color: red;">複数選択可</span>
            </label>

            <div class="d-flex flex-wrap" style="gap: 12px;">
                @foreach ($seasons as $season)
                <label class="form-check-label d-flex align-items-center" style="gap: 4px;">
                    @php
                    $checkedSeasons = old('seasons', $selectedSeasons ?? []);
                    $checkedSeasons = is_array($checkedSeasons) ? $checkedSeasons : (array) $checkedSeasons;
                    @endphp

                    <input type="checkbox"
                        name="seasons[]"
                        value="{{ $season->id }}"
                        {{ in_array($season->id, $checkedSeasons) ? 'checked' : '' }}>
                    <span>{{ $season->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @error('seasons')
        <div class="text-danger small">{{ $message }}</div>
        @enderror

        {{-- 商品説明文 --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                商品説明文
                <span class="badge bg-danger ms-2">必須</span>
            </label>
            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
            @error('description')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-center mt-4" style="gap: 16px;">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                戻る
            </a>

            <button class="btn px-4"
                style="background-color: #FFD700; color: #000; font-weight: bold;">
                登録する
            </button>
        </div>

    </form>

</div>
@endsection