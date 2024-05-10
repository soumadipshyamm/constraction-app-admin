<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path() . '/data/adminMenu.json');
        $data = json_decode($json);
        // dd($data);
        foreach ($data->adminMenu as $key => $value) {
            AdminMenu::updateOrCreate([
                'name' => $value->name,
            ]);
        }
    }
}
