<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'IT & Jaringan'],
            ['name' => 'Kebersihan'],
            ['name' => 'Fasilitas Kelas'],
            ['name' => 'Sarana & Prasarana'],
            ['name' => 'Keamanan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
