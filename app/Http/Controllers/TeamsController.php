<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TeamsController extends Controller
{
    public function index() {
        $teams = Team::with('projects:id,title')->get()->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'projects' => $team->projects->pluck('title')->toArray(),
            ];
        });
        
        return Inertia::render('teams/Index', [
            'teams' => $teams,
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
            'project_ids' => 'array',
            'project_ids.*' => 'exists:projects,id',
        ]);

        $team = Team::create(['name' => $data['name']]);

        $team->users()->sync($data['user_ids']);
        $team->projects()->sync($data['project_ids']);

        foreach ($data['project_ids'] as $projectId) {
            $project = Project::find($projectId);
            $project->users()->syncWithoutDetaching($data['user_ids']);
        }

        return redirect()->route('teams.index')->with('message','Time criado!');
    }

    public function register() {
        return Inertia::render('teams/Create', [
            'users' => User::all(['id', 'name']),
            'projects' => Project::all(['id', 'title']),
        ]);
    }

    public function edit($id)
    {
        $team = Team::with(['users:id', 'projects:id'])->findOrFail($id);

        return Inertia::render('teams/Edit', [
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'user_ids' => $team->users->pluck('id'),
                'project_ids' => $team->projects->pluck('id'),
            ],
            'users' => User::select('id', 'name')->get(),
            'projects' => Project::select('id', 'title')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
        ]);

        $team = Team::findOrFail($id);
        $team->update(['name' => $data['name']]);

        $userIds = $data['user_ids'] ?? [];
        $projectIds = $data['project_ids'] ?? [];

        $team->users()->sync($userIds);
        $team->projects()->sync($projectIds);

        foreach ($projectIds as $projectId) {
            DB::table('project_user')
                ->where('project_id', $projectId)
                ->whereIn('user_id', $team->users()->pluck('users.id'))
                ->delete();
        }

        foreach ($projectIds as $projectId) {
            $project = Project::find($projectId);
            $project->users()->syncWithoutDetaching($userIds);
        }

        return redirect()->route('teams.index')->with('message', 'Equipe atualizada com sucesso!');
    }

    public function delete($id) {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('teams.index')->with('message', 'Time deletado com sucesso!');
    }
}
