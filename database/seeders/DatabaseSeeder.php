<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\FacultySeeder;
use Database\Seeders\ProgramSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SuperAdminSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FacultySeeder::class,
            ProgramSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            AdminFacultySeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}
