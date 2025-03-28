<?php

namespace Lareon\Modules\Tag\Database\Seeders;

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
                'title' => 'admin.tag.read',
                'description' => 'have access to read one or all tags (in the admin panel)',
            ],
            [
                'title' => 'admin.tag.create',
                'description' => 'have access to create a new tag (in the admin panel)',
            ],
            [
                'title' => 'admin.tag.edit',
                'description' => 'have access to edit tags (in the admin panel)',
            ],
            [
                'title' => 'admin.tag.delete',
                'description' => 'have access to delete tags (in the admin panel)',
            ],
        ]);
    }
}
