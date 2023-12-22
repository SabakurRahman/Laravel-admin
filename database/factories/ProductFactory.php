<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $product_type = random_int(Product::PRODUCT_SIMPLE, Product::PRODUCT_TYPE_GROUPED);
        $country = Country::query()->inRandomOrder()->first()->id ?? 1;
        $auth_id = User::query()->inRandomOrder()->first()->id ?? 1;
        return [
            'title'                => $title,
            'slug'                 => Str::slug($title),
            'sku'                  => $this->faker->word(),
            'model'                => $this->faker->word(),
            'product_type'         => $product_type,
            'is_published'         => Product::STATUS_PUBLISHED,
            'is_show_on_home_page' => 1,
            'is_allow_review'      => 1,
            'is_new'               => 1,
            'is_prime'             => 1,
            'sort_order'           => 1,
            'description'          => $this->faker->paragraph(),
            'short_description'    => $this->faker->paragraph(),
            'comment'              => '',
            'country_id'           => $country,
            'warehouse_id'         => 1,
            'manufacturer_id'      => 1,
            'vendor_id'            => 1,
            'user_id'              => $auth_id,
        ];
    }
}
