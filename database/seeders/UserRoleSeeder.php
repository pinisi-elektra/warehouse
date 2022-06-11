<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existingUser = User::latest()->first();
        if (!$existingUser) {
            if (isset($this->command)) {
                $this->command->getOutput()->error('please the artisan nova:user first');
            }

            return;
        }

        $role = Role::create(['name' => 'Admin']);

        UserRole::create([
           'user_id' => $existingUser->getKey(),
           'role_id' => $role->getKey()
        ]);
    }
}
