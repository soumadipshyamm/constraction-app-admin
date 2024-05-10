<?php

namespace Database\Seeders;

use App\Models\InvInwardEntryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvInwardEntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path() . '/data/InvInwardEntryType.json');
        $data = json_decode($json);
        // dd($data);
        foreach ($data->entryType as $key => $value) {
            InvInwardEntryType::updateOrCreate([
                'name' => $value->name,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}
