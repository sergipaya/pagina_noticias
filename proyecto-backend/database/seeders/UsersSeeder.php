<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@email.com';
        $admin->password = '$2y$10$uKLjyCzWCRcM.Dp6f.ML4e/5dhCIGVfvlu8hHiFmFEyuf97likLUq';
        $admin->save();
        $admin->roles()->attach(2);

        for ($i = 1; $i <= 10; $i ++) {
            $user = new User();
            $user->name = 'user' . $i;
            $user->email = 'user'  . $i . '@email.com';
            $user->password = '$2y$10$uKLjyCzWCRcM.Dp6f.ML4e/5dhCIGVfvlu8hHiFmFEyuf97likLUq';
            $user->save();
            $user->roles()->attach(1);
        }
    }
}
