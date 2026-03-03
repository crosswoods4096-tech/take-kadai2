<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0|max:10000',
            'image'       => 'nullable|image|mimes:jpeg,png|max:2048',
            'seasons'     => 'required|array',
            'seasons.*'   => 'integer|exists:seasons,id',
            'description' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => '商品名は必須です。',
            'price.required'       => '値段は必須です。',
            'price.integer'        => '値段は数値で入力してください。',
            'price.max'            => '値段は10000円以内で入力してください。',
            'image.image'          => '商品画像は画像ファイルを選択してください。',
            'image.mimes'          => '商品画像はjpegまたはpng形式でアップロードしてください。',
            'seasons.required'     => '季節は1つ以上選択してください。',
            'description.required' => '商品説明は必須です。',
            'description.max'      => '商品説明は120文字以内で入力してください。',
        ];
    }
}
