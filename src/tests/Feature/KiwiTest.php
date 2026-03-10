<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品一覧画面にキウイが表示される()
    {
        // Arrange: キウイの商品データを作成
        Product::factory()->create([
            'name' => 'キウイ',
            'description' => '甘みと酸味のバランスが絶妙なフルーツです。',
            'price' => 800,
            'image' => 'image.kiwi.png',
        ]);

        // Act: 商品一覧ページにアクセス
        $response = $this->get('/products');

        // Assert: キウイが表示されていること
        $response->assertStatus(200);
        $response->assertSee('キウイ');
    }
}
