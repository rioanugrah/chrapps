<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \Carbon\Carbon;

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

        $user = User::factory()->create([
            'generate' => Str::uuid()->toString(),
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'admin@admin.com',
            'password' => \Hash::make('admin123'),
            'email_verified_at' => Carbon::now()
        ]);

        $permissions = [
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-update',
            'permission-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-update',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-update',
            'user-delete',
        ];

        $dataPermission = [];
        foreach ($permissions as $permission) {
            $data = Permission::create(['name' => $permission]);
            $dataPermission[] = $data->name;
        }

        $role = Role::create(['name' => 'Administrator']);
        $role->syncPermissions($dataPermission);

        $user->assignRole(1);
    }
}
