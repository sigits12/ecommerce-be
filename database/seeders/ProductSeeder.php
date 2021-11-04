<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create([
            'sku' => 'B04112021-1',
            'nama_product' => 'masker1',
            'harga' => 11000,
		]);
		
		$product = Product::create([
            'sku' => 'B04112021-2',
            'nama_product' => 'masker2',
            'harga' => 11000,
		]);
		
		$product = Product::create([
            'sku' => 'B04112021-3',
            'nama_product' => 'masker3',
            'harga' => 11000,
        ]);
    }
}