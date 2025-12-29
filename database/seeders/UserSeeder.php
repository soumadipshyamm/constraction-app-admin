<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Request $request): void
    {
        $faker = Faker::create();
        $adminUser = new User();
        $adminUser->uuid = $faker->uuid;
        $adminUser->first_name = 'Super';
        $adminUser->last_name = 'Admin';
        $adminUser->username = 'superadmin';
        $adminUser->email = 'admin@abc.com';
        $adminUser->mobile_number = 9191244321;
        $adminUser->email_verified_at = $faker->dateTime();
        $adminUser->mobile_number_verified_at = $faker->dateTime();
        $adminUser->password = bcrypt('12345678');
        $adminUser->registration_ip = $request->getClientIp();
        $adminUser->admin_role_id  = 1;
        $adminUser->is_active = 1;
        $adminUser->save();
    }
}
