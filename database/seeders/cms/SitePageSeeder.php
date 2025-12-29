<?php

namespace Database\Seeders\cms;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Admin\PageManagment;
use App\Models\Admin\Cms\BannerPage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SitePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path() . '/data/sitepage.json');
        $data = json_decode($json);
        // dd($data);
        foreach ($data->sitepage as $key => $value) {
            PageManagment::updateOrCreate([
                'page_name' => $value->name,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}
