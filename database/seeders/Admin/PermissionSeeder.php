<?php

namespace Database\Seeders\Admin;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Company\Company_permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'add',
                    'edit',
                    'view',
                    'delete',
                ],
            ],
            [
                'group_name' => 'Company User',
                'permissions' => [
                    'add',
                    'edit',
                    'view',
                    'delete',
                ],
            ],
            [
                'group_name' => 'Company  Role Permissions',
                'permissions' => [
                    'add',
                    'edit',
                    'view',
                    'delete',
                ],
            ],
            [
                'group_name' => 'Company Master',
                'permissions' => [
                    'add',
                    'edit',
                    'view',
                    'delete',
                ],
            ],
            [
                'group_name' => 'Company subscriber',
                'permissions' => [
                    'add',
                    'edit',
                    'view',
                    'delete',
                ],
            ],

        ];


        // $json = file_get_contents(database_path() . '/data/companyMenu.json');
        // $data = json_decode($json);
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];

            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permissionName = $permissions[$i]['permissions'][$j];
                // $permissionSlug = $permissions[$i]['permissions'][$j];
                Company_permission::create([
                    'name' => $permissionName,
                    'slug' => Str::slug($permissionGroup.'-'.$permissionName),
                    // 'group' => $permissionGroup,
                ]);
            }
            // print_r($permissionGroup);
        }

    }
}
