<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * seed permission
         */
        $role_admin = Role::create(['name' => 'Administrator']);
        $role_agen = Role::create(['name' => 'Agen']);

        // administrator
        $admin_permissions = [
            'list-agent',
            'assign-agent',
            'create-campaign',
            'update-campaign',
            'delete-campaign',
            'create-income',
            'view-income',
            'create-outcome',
            'view-outcome',
            'list-rekapitulasi',
        ];

        foreach ($admin_permissions as $admin_p) {
            Permission::create(['name' => $admin_p]);
            $role_admin->givePermissionTo($admin_p);
        }

        // agen
        $agen_permissions = [
            'list-campaign-agent',
            'create-distribution-point',
        ];

        foreach ($agen_permissions as $agen_p) {
            Permission::create(['name' => $agen_p]);
            $role_agen->givePermissionTo($agen_p);
        }
    }
}
