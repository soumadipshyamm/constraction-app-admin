<?php

namespace Database\Seeders\Company;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Company\Company_permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanyPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // echo "Seeding";
        $json = file_get_contents(database_path() . '/data/companyMenu.json');
        $data = json_decode($json);
        foreach ($data->companyMenu as $key => $value) {
            Company_permission::updateOrCreate([
                'name' => $value->name,
                'slug' => Str::slug($value->name),
            ]);
        }
    }
}
