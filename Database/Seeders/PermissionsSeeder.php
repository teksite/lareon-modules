<?php

namespace Lareon\Modules\Seo\Database\Seeders;

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

            /* Site */
            [
                'title'=>'admin.seo.site.edit',
                'description'=>'have access to edit the site seo (in the admin panel)',
            ],
            /* General */
            [
                'title'=>'admin.seo.general.edit',
                'description'=>'have access to edit seo of the general part of the app (in the admin panel)',
            ],
            /* Sitemap */
            [
                'title'=>'admin.seo.sitemap.edit',
                'description'=>'have access to generate or edit the type of sitemap (in the admin panel)',
            ],
            /* Robot.txt */
            [
                'title'=>'admin.seo.robot.edit',
                'description'=>'have access to edit robot.txt file (in the admin panel)',
            ],
        ]);
    }
}
