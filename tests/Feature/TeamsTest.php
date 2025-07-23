<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Status;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeamsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'Administrador']);
        $user = User::factory()->create();
        $user->assignRole('Administrador');
        $this->actingAs($user);
    }

    public function test_index_returns_team_list()
    {
        $team = Team::factory()->create();
        Status::factory()->create();
        $project = Project::factory()->create();
        $team->projects()->attach($project);

        $response = $this->get(route('teams.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('teams/Index')
                ->has('teams', 1)
        );
    }

    public function test_can_create_team()
    {
        $users = User::factory(3)->create();
        Status::factory()->create();
        $projects = Project::factory(2)->create();

        $data = [
            'name' => 'Equipe Teste',
            'user_ids' => $users->pluck('id')->toArray(),
            'project_ids' => $projects->pluck('id')->toArray(),
        ];

        $response = $this->post(route('teams.create'), $data);

        $response->assertRedirect(route('teams.index'));
        $this->assertDatabaseHas('teams', ['name' => 'Equipe Teste']);
        $this->assertDatabaseCount('project_team', 2);
        $this->assertDatabaseCount('team_user', 3);
    }

    public function test_can_view_register_form()
    {
        $response = $this->get(route('teams.register'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('teams/Create')
                ->has('users')
                ->has('projects')
        );
    }

    public function test_can_edit_team()
    {
        $team = Team::factory()->create();
        $users = User::factory(2)->create();
        Status::factory()->create();
        $projects = Project::factory(2)->create();
        $team->users()->attach($users);
        $team->projects()->attach($projects);

        $response = $this->get(route('teams.edit', $team->id));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('teams/Edit')
                ->where('team.id', $team->id)
                ->has('team.user_ids')
                ->has('team.project_ids')
        );
    }

    public function test_can_update_team()
    {
        $team = Team::factory()->create();
        $users = User::factory(2)->create();
        Status::factory()->create();
        $projects = Project::factory(2)->create();

        $data = [
            'name' => 'Equipe Atualizada',
            'user_ids' => $users->pluck('id')->toArray(),
            'project_ids' => $projects->pluck('id')->toArray(),
        ];

        $response = $this->put(route('teams.update', $team->id), $data);

        $response->assertRedirect(route('teams.index'));
        $this->assertDatabaseHas('teams', ['id' => $team->id, 'name' => 'Equipe Atualizada']);
        $this->assertDatabaseCount('project_team', 2);
        $this->assertDatabaseCount('team_user', 2);
    }

    public function test_can_delete_team()
    {
        $team = Team::factory()->create();

        $response = $this->delete(route('teams.delete', $team->id));

        $response->assertRedirect(route('teams.index'));
        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
