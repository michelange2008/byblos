<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Crée les rôles de base
        $roles = ['admin', 'editor', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Associe ton compte à admin
        $user = User::where('email', 'michelange@wanadoo.fr')->first();

        if ($user) {
            $adminRole = Role::where('name', 'admin')->first();
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
