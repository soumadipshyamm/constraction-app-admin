<?php

namespace Database\Seeders;

use App\Models\InvIssueList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvIssueListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path() . '/data/InvIssueList.json');
        $data = json_decode($json);
        // dd($data);
        foreach ($data->InvIssueList as $key => $value) {
            InvIssueList::updateOrCreate([
                'name' => $value->name,
                'uuid' => Str::uuid(),
            ]);
        }
    }
}
