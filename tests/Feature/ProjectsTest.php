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

    public function test_user_can_create_a_project()
    {
        $this->authenticatedUser();
        Status::factory()->create();
        $response = $this->post(route('projects.create'), [
            'client' => 'Cliente Exemplo',
            'title' => 'Projeto Exemplo',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'client' => 'Cliente Exemplo',
            'title' => 'Projeto Exemplo',
        ]);
    }

    public function test_user_can_edit_a_project()
    {
        $this->authenticatedUser();
        Status::factory()->create();
        $project = Projects::factory()->create();

        $response = $this->put(route('projects.update', $project), [
            'client' => 'Cliente Editado',
            'title' => 'Projeto Editado',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'client' => 'Cliente Editado',
            'title' => 'Projeto Editado',
        ]);
    }

    public function test_user_can_delete_a_project()
    {
        $this->authenticatedUser();
        Status::factory()->create();
        $project = Projects::factory()->create();

        $response = $this->delete(route('projects.delete', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
