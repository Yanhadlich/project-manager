<?php

namespace Tests\Feature;

use App\Models\Projects;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    private function authenticatedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function test_user_can_view_projects_list()
    {
        $this->authenticatedUser();
        Status::factory()->create();
        Projects::factory()->count(3)->create();

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('projects/Index')
                 ->has('projects', 3)
        );
    }    
}
