<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名を入力し値段を入力しない場合はエラーメッセージが表示される()
    {
        // 商品名は入力、値段は未入力
        $response = $this->post('/products', [
            'name' => 'キウイ',
            'price' => '', // 未入力
            'image' => null,
            'seasons' => [],
            'description' => '',
        ]);

        // バリデーションエラーを確認
        $response->assertSessionHasErrors([
            'price' => '値段を入力してください。',
        ]);
    }
}
