<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRol = Role::create([
            'name' => 'admin',
            'label' => 'administrador'
        ]);

        $sellerRol = Role::create([
            'name' => 'seller',
            'label' => 'vendedor'
        ]);

        $permissions = [
            'create' => 'crear',
            'read' => 'listar',
            'update' => 'editar',
            'delete' => 'eliminar'
        ];

        $roles = Role::all();
        foreach ($roles as $rol) {
            foreach ($permissions as $index => $permission) {
                Permission::create([
                    'name' => $rol->name . ' ' . $index,
                    'label' => $rol->label . ' ' . $permission
                ]);
            }
        }

        $adminRol->syncPermissions(Permission::all());
        $sellerRol->syncPermissions(Permission::where('name', 'LIKE', "%seller%")->get());

        $admin = User::find(1);
        $admin->assignRole('admin');

        $seller = User::find(2);
        $seller->assignRole('seller');
    }
}
