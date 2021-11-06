<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{
    protected $user;

    protected function authenticateAdmin()
    {
        $user = User::where('email', 'admin@mail.id')->first();
        $this->user = $user;
        $token = JWTAuth::fromUser($this->user);
        return $token;
    }

    protected function authenticateUser()
    {
        $user = User::where('email', 'user@mail.id')->first();
        $this->user = $user;
        $token = JWTAuth::fromUser($this->user);
        return $token;
    }

    public function testIndexReturnsDataValidFormat()
    {
        $token = $this->authenticateAdmin();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('get', route('products.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'sku',
                            'nama_product',
                            'harga',
                            'created_at',
                            'updated_at',
                        ]
                    ],
                    'pagination' => [
                        'total',
                        'count',
                        'per_page',
                        'current_page',
                        'total_pages',
                    ]
                ]
            );
    }

    public function testOnlyAdminCanCreateProduct()
    {
        $token = $this->authenticateUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('post', route('products.create'));

        $response->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJsonStructure(
                [
                    'message'
                ]
            );
    }

    public function testCreateProduct()
    {
        $token = $this->authenticateAdmin();

        $payload = [
            'sku' => 'SN-001-06112021',
            'nama_product' => 'Sepatu Nike',
            'harga' => 500000
        ];

        if (Product::find($payload['sku'])) {
            Product::destroy($payload['sku']);
        };

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('post', route('products.create'), $payload);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'sku',
                    'nama_product',
                    'harga',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
