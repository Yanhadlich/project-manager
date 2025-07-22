<?php

namespace Tests\Feature;

use App\Models\Projects;
use App\Models\Status;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    private function makeUserWithRole(string $roleName)
    {
        Role::create(['name' => $roleName]);
        $user = User::factory()->create();
        $user->assignRole($roleName);
        $this->actingAs($user);
        return $user;
    }

    public function test_any_authenticated_user_can_view_list()
    {
        $this->makeUserWithRole('Cliente');  
        Status::factory()->create();
        Projects::factory()->count(3)->create();

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('projects/Index')
                 ->has('projects', 3)
        );
    }

    public function test_non_privileged_user_cannot_create_project()
    {
        $this->makeUserWithRole('Cliente');
        Status::factory()->create();

        $response = $this->post(route('projects.create'), [
            'client' => 'A',
            'title' => 'B',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_privileged_roles_can_create_project()
    {
        foreach (['Administrador', 'Gerente', 'Desenvolvedor'] as $role) {
            $this->makeUserWithRole($role);
            Status::factory()->create();

            $response = $this->post(route('projects.create'), [
                'client' => 'Cliente Exemplo',
                'title' => 'Projeto Exemplo',
            ]);

            $response->assertRedirect(route('projects.index'));
            $this->assertDatabaseHas('projects', [
                'client' => 'Cliente Exemplo',
                'title' => 'Projeto Exemplo'
            ]);

            Projects::query()->delete(); 
        }
    }

    public function test_edit_and_delete_respects_roles()
    {
        Status::factory()->create();
        $project = Projects::factory()->create();

        
        $this->makeUserWithRole('Cliente');
        $this->put(route('projects.update', $project), ['client'=>'X','title'=>'Y'])
             ->assertStatus(403);
        $this->delete(route('projects.delete', $project))
             ->assertStatus(403);

        
        foreach (['Administrador','Gerente','Desenvolvedor'] as $role) {
            $this->makeUserWithRole($role);
            $res1 = $this->put(route('projects.update', $project), [
                'client' => 'Edit '.$role,
                'title' => 'Title '.$role,
                'status' => ['id' => 1, 'name' => 'Active'],
            ]);
            $res1->assertRedirect(route('projects.index'));
            $this->assertDatabaseHas('projects', ['client' => 'Edit '.$role]);

            $res2 = $this->delete(route('projects.delete', $project));
            if ($role === 'Desenvolvedor') {
                $res2->assertStatus(403);
                continue;
            }
            $res2->assertRedirect(route('projects.index'));
            $project = Projects::factory()->create(); 
        }
    }
}
