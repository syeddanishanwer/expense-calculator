<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $categories = [
        'Food & Dining',
        'Transportation',
        'Shopping',
        'Entertainment',
        'Health & Medical',
        'Utilities & Bills',
        'Education',
        'Travel',
        'Other',
    ];

    foreach ($categories as $category) {
        \App\Models\Category::create(['name' => $category]);
    }
}
}
