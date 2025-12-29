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


// INSERT INTO company_permissions (name, slug) VALUES
// ('PR Management', 'pr-management'),
// ('Companies', 'companies'),
// ('Projects', 'projects'),
// ('Subproject', 'subproject'),
// ('Units', 'units'),
// ('Warehouses', 'warehouses'),
// ('Labours', 'labours'),
// ('Assets Equipments', 'assets-equipments'),
// ('Vendors', 'vendors'),
// ('Activities', 'activities'),
// ('Materials', 'materials'),
// ('Manage Teams', 'manage-teams'),
// ('User Roles and Permissions', 'user-roles-and-permissions'),
// ('PR Approval Manage', 'pr-approval-manage'),
// ('PR', 'pr'),
// ('Work Progress Reports', 'work-progress-reports'),
// ('Work Progress Details', 'work-progress-details'),
// ('DPR', 'dpr'),
// ('Resources Usage From DPR', 'resources-usage-from-dpr'),
// ('Material Used Vs Store Issue', 'material-used-vs-store-issue'),
// ('Inventory Reports', 'inventory-reports'),
// ('RFQ', 'rfq'),
// ('GRN (MRN) Slip', 'grn-mrn-slip'),
// ('GRN (MRN) Details', 'grn-mrn-details'),
// ('ISSUE Slip', 'issue-slip'),
// ('Issue (Outward) Details', 'issue-outward-details'),
// ('Issue Return', 'issue-return'),
// ('Global Stock Details', 'global-stock-details'),
// ('Project Stock Statement', 'project-stock-statement'),
// ('Subscription', 'subscription');