<?php

namespace Database\Seeders\cms;

use Illuminate\Support\Str;
use App\Models\Admin\Cms\HomePage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class homePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path() . '/data/homepage.json');
        $data = json_decode($json);
        // dd($data);
        foreach ($data->homepage as $key => $value) {
            HomePage::updateOrCreate([
                'name' => $value->name,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}
