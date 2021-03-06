<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'is_admin']);
    	Permission::create(['name' => 'crud_patients']);
    	Permission::create(['name' => 'crud_prescribers']);
    	Permission::create(['name' => 'crud_determinations']);
    	Permission::create(['name' => 'crud_reports']);
    	Permission::create(['name' => 'crud_protocols']);
        Permission::create(['name' => 'print_worksheets']);
    	Permission::create(['name' => 'print_protocols']);
    	Permission::create(['name' => 'crud_practices']);
    	Permission::create(['name' => 'sign_practices']);
    	Permission::create(['name' => 'see_statistics']);
    	Permission::create(['name' => 'restore_items']);
    	Permission::create(['name' => 'generate_security_codes']);
    	Permission::create(['name' => 'settings']);
        Permission::create(['name' => 'system_logs']);
        Permission::create(['name' => 'activity_logs']);


        Permission::create(['name' => 'is_user']);

    }
}
