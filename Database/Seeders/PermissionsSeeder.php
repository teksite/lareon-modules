<?php

namespace Lareon\Modules\Blog\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Teksite\Authorize\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->insert([

            /* categories */
            [
                'title'=>'admin.blog.category.read',
                'description'=>'have access to read one or all blog categories (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.category.create',
                'description'=>'have access to create a new blog category (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.category.edit',
                'description'=>'have access to edit blog categories (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.category.delete',
                'description'=>'have access to delete blog categories (in the admin panel)',
            ],
            /* Posts */
            [
                'title'=>'admin.blog.post.read',
                'description'=>'have access to read one or all blog posts (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.post.create',
                'description'=>'have access to create a new blog post (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.post.edit',
                'description'=>'have access to edit blog posts (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.post.delete',
                'description'=>'have access to delete blog posts (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.post.trash',
                'description'=>'have access to delete blog posts from database (in the admin panel)',
            ],
            /* Annotation */
            [
                'title'=>'admin.blog.annotation.read',
                'description'=>'have access to read one or all blog annotations (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.annotation.create',
                'description'=>'have access to create a new blog annotation (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.annotation.edit',
                'description'=>'have access to edit blog annotations (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.annotation.delete',
                'description'=>'have access to delete blog annotations (in the admin panel)',
            ],
            [
                'title'=>'admin.blog.annotation.trash',
                'description'=>'have access to delete blog annotations from database (in the admin panel)',
            ],

        ]);
    }
}
