<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'add.admin']);
        Permission::create(['name' => 'delete.admin']);
        Permission::create(['name' => 'see.admins']);
        Permission::create(['name' => 'add.pm']);
        Permission::create(['name' => 'delete.pm']);
        Permission::create(['name' => 'see.pms']);
        Permission::create(['name' => 'change.project']);
        Permission::create(['name' => 'see.projects']);
        Permission::create(['name' => 'change.client']);
        Permission::create(['name' => 'change.user.project']);
        Permission::create(['name' => 'see.user.projects']);


        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo(['add.admin', 'delete.admin', 'see.admins', 'add.pm', 'delete.pm', 'see.pms', 'change.project', 'see.projects', 'change.client']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['add.pm', 'delete.pm', 'see.pms', 'change.project', 'see.projects', 'change.client']);

        $role = Role::create(['name' => 'pm']);
        $role->givePermissionTo(['see.pms', 'change.project', 'see.projects']);

        $role = Role::create(['name' => 'client']);
        $role->givePermissionTo(['change.user.project', 'see.user.projects']);

        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo(['see.pms', 'change.project', 'see.projects']);

        $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo(['see.pms', 'change.project', 'see.projects']);

        $role = Role::create(['name' => 'production']);
        $role->givePermissionTo(['see.pms', 'change.project', 'see.projects','change.client','see.user.projects','change.user.project']);

        $role = Role::create(['name' => 'partner']);
        $role->givePermissionTo(['see.pms', 'change.project', 'see.projects']);
    }
}
