<?php

namespace Lareon\Modules\Comment\Database\Seeders;

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

            /* Admin */
            [
                'title'=>'admin.comment.read',
                'description'=>'have access to read one or all blog posts (in the admin panel)',
            ],
            [
                'title'=>'admin.comment.create',
                'description'=>'have access to create a new blog post (in the admin panel)',
            ],
            [
                'title'=>'admin.comment.edit',
                'description'=>'have access to edit blog posts (in the admin panel)',
            ],
            [
                'title'=>'admin.comment.delete',
                'description'=>'have access to delete blog posts (in the admin panel)',
            ],
            [
                'title'=>'admin.comment.trash',
                'description'=>'have access to delete blog posts from database (in the admin panel)',
            ],
            /* Client */
            [
                'title'=>'client.comment.read',
                'description'=>'have access to read one or all blog annotations (in the admin panel)',
            ],
            [
                'title'=>'client.comment.create',
                'description'=>'have access to create a new blog annotation (in the admin panel)',
            ],
            [
                'title'=>'client.comment.edit',
                'description'=>'have access to edit blog annotations (in the admin panel)',
            ],
            [
                'title'=>'client.comment.delete',
                'description'=>'have access to delete blog annotations (in the admin panel)',
            ],
        ]);
    }
}
