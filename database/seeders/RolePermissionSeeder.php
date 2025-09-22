<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Human Resources role
        $hr = Role::firstOrCreate(['name' => 'Human Resources']);
        $hr->givePermissionTo([
            'careerCreate',
            'careerRead',
            'careerUpdate',
            'careerDelete',
            'userCreate',
            'userRead',
            'userUpdate',
            'userDelete',
            'contactRead',
            'contactDelete'
        ]);

        // Create Sales role
        $sales = Role::firstOrCreate(['name' => 'Sales']);
        $sales->givePermissionTo([
            'quoterequestsRead',
            'quoterequestsDelete',
            'contactRead',
            'contactDelete',
            'productCreate',
            'productRead',
            'productUpdate',
            'productDelete',
            'categoryCreate',
            'categoryRead',
            'categoryUpdate',
            'categoryDelete',
            'reviewCreate',
            'reviewRead',
            'reviewUpdate',
            'reviewDelete',
            'specialsCreate',
            'specialsRead',
            'specialsUpdate',
            'specialsDelete'
        ]);

        // Create Webmaster role
        $webmaster = Role::firstOrCreate(['name' => 'Webmaster']);
        $webmaster->givePermissionTo([
            'blogCreate',
            'blogRead',
            'blogUpdate',
            'blogDelete',
            'blogCategoryCreate',
            'blogCategoryRead',
            'blogCategoryDelete',
            'seoRead',
            'seoUpdate',
            'faqCreate',
            'faqRead',
            'faqUpdate',
            'faqDelete',
            'generalRead',
            'generalUpdate',
            'productRead',
            'productUpdate',
            'categoryRead',
            'categoryUpdate',
            'areasweserveCreate',
            'areasweserveRead',
            'areasweserveUpdate',
            'areasweserveDelete',
            'diyCreate',
            'diyRead',
            'diyUpdate',
            'diyDelete'
        ]);

        // Create SuperAdmin role
        $superAdmin = Role::firstOrCreate(['name' => 'SuperAdmin']);

        // Get all permissions and assign to SuperAdmin
        $permissions = Permission::all();
        $superAdmin->givePermissionTo($permissions);

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('- Human Resources: ' . $hr->permissions()->count() . ' permissions');
        $this->command->info('- Sales: ' . $sales->permissions()->count() . ' permissions');
        $this->command->info('- Webmaster: ' . $webmaster->permissions()->count() . ' permissions');
        $this->command->info('- SuperAdmin: ' . $superAdmin->permissions()->count() . ' permissions');
        $this->command->info('Note: Roles created but not assigned to users. Assign manually through admin interface.');
    }
}