<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'teacher']);
        $role = Role::create(['name' => 'student']);
        // \App\Models\User::factory(10)->create();
        $this->call([
            FacultySeeder::class,
            ProgramSeeder::class,

        ]);
    }
}
