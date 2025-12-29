<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\Admin\Role;
use Database\Seeders\cms\homePageSeeder;
use Database\Seeders\cms\SitePageSeeder;
use Database\Seeders\Admin\AdminMenuSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Company\CompanyPermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(Role::class);
        $this->call(PermissionSeeder::class);
        $this->call(AdminMenuSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(homePageSeeder::class);
        $this->call(SitePageSeeder::class);
        $this->call(CompanyPermissionSeeder::class);
        $this->call(InvInwardEntryTypeSeeder::class);
        $this->call(InvIssueListSeeder::class);
    }
}
