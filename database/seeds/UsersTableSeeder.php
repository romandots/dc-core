<?php
/**
 * File: UsersTableSeeder.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */
declare(strict_types=1);

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Role;
use \App\User;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run(): void
    {
        if (Role::query()->where('name', 'admin')->count() === 0) {
            Role::query()
                ->create([
                    'name' => 'admin'
                ]);
        }
        if (User::query()->where('username', 'admin')->count() === 0) {
            Role::query()
                ->create([
                    'name' => 'admin'
                ]);
            /** @var User $user */
            $user = User::query()
                ->firstOrCreate([
                    'name' => 'Admin',
                    'username' => 'admin',
                    'password' => \Hash::make('12345678')
                ]);
            $user->assignRole('admin');
        }
    }
}
