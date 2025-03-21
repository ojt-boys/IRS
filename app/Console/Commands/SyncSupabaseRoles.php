<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SyncSupabaseRoles extends Command
{
    protected $signature = 'sync:supabase-roles';  // ✅ Ensure this is correct
    protected $description = 'Sync roles and permissions from Supabase to Spatie';

    public function handle()
    {
        $this->info('Syncing roles and permissions from Supabase...');

        try {
            // Fetch roles from Supabase
            $roles = DB::table('roles')->get();

            foreach ($roles as $role) {
                $spatieRole = Role::firstOrCreate(['name' => $role->name, 'guard_name' => 'web']);
                $this->info("Synced role: {$role->name}");
            }

            // Sync permissions
            $permissions = DB::table('permissions')->get();
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission->name, 'guard_name' => 'web']);
                $this->info("Synced permission: {$permission->name}");
            }

            $users = User::all();
            foreach ($users as $user) {
                $userRoles = DB::table('model_has_roles')
                    ->where('model_id', $user->id)
                    ->pluck('role_id');

                $rolesToSync = Role::whereIn('id', $userRoles)->pluck('name')->toArray();
                $user->syncRoles($rolesToSync);

                $this->info("Synced roles for user: {$user->email}");
            }

            $this->info('Roles and permissions synced successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to sync roles and permissions: ' . $e->getMessage());
        }
    }
}
