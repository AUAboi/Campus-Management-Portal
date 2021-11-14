<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'student']);
        Role::create(['name' => 'teacher']);

        Permission::create(['name' => 'create faculties']);
        Permission::create(['name' => 'update faculties']);
        Permission::create(['name' => 'delete faculties']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        $this->call([
            FacultySeeder::class,
            ProgramSeeder::class,

        ]);
    }
}
