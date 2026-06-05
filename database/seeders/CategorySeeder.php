<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        collect([
            'Dresses',
            'Jackets',
            'Jeans',
            'Shoes',
            'T-Shirts',
            'Sweaters',
            'Accessories',
            'Bag',
        ])->each(function (string $categoryName): void {
            Category::updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );
        });
    }
}
