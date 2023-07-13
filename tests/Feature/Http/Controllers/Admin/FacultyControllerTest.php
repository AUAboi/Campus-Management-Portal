<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Faculty;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class FacultyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        //Seed roles
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $this->user = User::factory()->create();
    }


    /** @test */
    public function faculty_page_loads()
    {
        Faculty::factory()->times(10)->create();

        $this->actingAs($this->user)
            ->get('/admin/faculties')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/Faculties/Index')
                    ->has('faculties.data', 0)
                    ->has('filters')
                    //default admin has no permissions allowed
                    ->has(
                        'permissions',
                        fn (AssertableInertia $page) => $page
                            ->where('create', false)
                    )
            );
    }
}
