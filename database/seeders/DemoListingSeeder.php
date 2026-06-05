<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DemoListingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'jan@example.com'],
            [
                'name' => 'Jan',
                'password' => 'password',
                'role' => User::ROLE_USER,
            ]
        );

        $category = Category::firstOrCreate([
            'name' => 'Shoes',
        ]);

        $listing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Adidas superstar black',
            'description' => 'Bardzo fajne buty, wygodne i bedą żyć długo.',
            'price' => 49.99,
            'size' => 'L',
            'condition' => 'good',
        ]);

        $this->addImageToListing($listing, 'adidas.png', true);
        $this->addImageToListing($listing, 'adidassize.png', false);


        $user = User::firstOrCreate(
            ['email' => 'yevhenii@example.com'],
            [
                'name' => 'Yevhenii',
                'password' => 'password',
                'role' => User::ROLE_USER,
            ]
        );

        $category = Category::firstOrCreate([
            'name' => 'Bag',
        ]);

        $listing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Plecak himawari fajny',
            'description' => 'Plecak himawari fajny w cudownym stanie, prawie nowy, piękny.',
            'price' => 19.99,
            'size' => 'M',
            'condition' => 'very good',
        ]);

        $this->addImageToListing($listing, 'back.png', true);
        $this->addImageToListing($listing, 'back2.png', false);

        $user = User::firstOrCreate(
            ['email' => 'yevhenii@example.com'],
            [
                'name' => 'Yevhenii',
                'password' => 'password',
                'role' => User::ROLE_USER,
            ]
        );

        $category = Category::firstOrCreate([
            'name' => 'Shoes',
        ]);

        $listing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Buty scarpa nowe',
            'description' => 'Dopiero ze sklepu, nie pasuje mi rozmiar, dlatego sprzedam.',
            'price' => 69.99,
            'size' => 'S',
            'condition' => 'very good',
        ]);

        $this->addImageToListing($listing, 'scarpa.png', true);

    }

    private function addImageToListing(Listing $listing, string $fileName, bool $isPrimary = false): void
    {
        $sourcePath = database_path('seeders/listings/' . $fileName);

        if (! File::exists($sourcePath)) {
            throw new \Exception("Seed image not found: " . $sourcePath);
        }

        $newFileName = uniqid() . '_' . $fileName;
        $destinationPath = 'listings/' . $newFileName;

        Storage::disk('public')->put(
            $destinationPath,
            File::get($sourcePath)
        );

        $listing->images()->create([
            'path' => $destinationPath,
            'is_primary' => $isPrimary,
        ]);
    }
}
