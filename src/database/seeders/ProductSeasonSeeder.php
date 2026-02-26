<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Season;

class ProductSeasonSeeder extends Seeder
{
    public function run()
    {
        // 商品名 → 季節名の対応表
        $data = [
            'キウイ' => ['秋', '冬'],
            'ストロベリー' => ['春'],
            'オレンジ' => ['冬'],
            'スイカ' => ['夏'],
            'ピーチ' => ['夏'],
            'シャインマスカット' => ['夏', '秋'],
            'パイナップル' => ['春', '夏'],
            'ブドウ' => ['夏', '秋'],
            'バナナ' => ['夏'],
            'メロン' => ['春', '夏'],
        ];

        foreach ($data as $productName => $seasonNames) {

            // 商品を取得
            $product = Product::where('name', $productName)->first();

            if (!$product) {
                continue; // 商品が存在しない場合はスキップ
            }

            // 季節IDを取得
            $seasonIds = Season::whereIn('name', $seasonNames)->pluck('id')->toArray();

            // 中間テーブルに登録
            $product->seasons()->sync($seasonIds);
        }
    }
}
