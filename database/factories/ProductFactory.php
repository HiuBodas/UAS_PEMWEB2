<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        $harga_beli = fake()->numberBetween(1000, 50000);
        return [
            'nama_produk' => fake()->word(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_beli * 1.25,
            'stok' => fake()->numberBetween(10, 100),
        ];
    }
}
