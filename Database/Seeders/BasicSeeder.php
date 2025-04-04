<?php

namespace Lareon\Modules\Blog\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lareon\Modules\Blog\App\Models\Category;

class BasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->insert([
            [
                'title'=>'uncategorized',
                'slug'=>'uncategorized',
            ], [
                'title'=>'articles',
                'slug'=>'articles',
            ]
        ]);
    }
}
