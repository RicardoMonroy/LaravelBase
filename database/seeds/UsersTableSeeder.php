<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        // super-admin
        $sadmin = User::create([
            'name' => 'Ricardo Monroy',
            'email' => 'rmonroy.rodriguez@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Spawn2001!'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $sadmin->assignRole('super-admin');

        // admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $admin->assignRole('administrador');

        // invitado
        $invite = User::create([
            'name' => 'Invitado',
            'email' => 'invitado@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $invite->assignRole('invitado');


    }
}
