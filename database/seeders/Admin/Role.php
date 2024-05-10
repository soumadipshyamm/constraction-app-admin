<?php

namespace Database\Seeders\Admin;

use Illuminate\Support\Str;
use App\Models\Admin\AdminRole;
use Illuminate\Database\Seeder;
use App\Models\Company\Company_role;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path() . '/data/roles.json');
        $data = json_decode($json);
        // dd($data);
        foreach ($data->roles as $key => $value) {
            AdminRole::updateOrCreate([
                'name' => $value->name,

            ]);
            Company_role::updateOrCreate([
                'name' => $value->name,
                'slug' => Str::slug($value->name),
                'company_id' => 1

            ]);
        }
    }
}
