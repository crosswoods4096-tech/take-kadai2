<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',              // 商品名：必須
            'price'       => 'required|integer|min:0|max:10000',     // 値段：必須・数値・0〜10000
            'image'       => 'required|image|mimes:jpeg,png|max:2048', // 画像：必須・jpeg/png
            'seasons'     => 'required|array',                       // 季節：必須
            'seasons.*'   => 'integer|exists:seasons,id',
            'description' => 'required|string|max:120',              // 説明文：必須・120字以内
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => '商品名を入力してください。',
            'price.required'       => '値段を入力してください。',
            'price.integer'        => '数値で入力してください。',
            'price.min'            => '0～10000円以内で入力してください。',
            'price.max'            => '0～10000円以内で入力してください。',
            'image.required'       => '画像を登録してください。',
            'image.image'          => '画像ファイルを選択してください。',
            'image.mimes'          => '「.png」または「.jpeg」形式でアップロードしてください。',
            'seasons.required'     => '季節を選択してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max'      => '120文字以内で入力してください。',
        ];
    }
}
