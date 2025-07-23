<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
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
        $request->validate([
            'name' => 'required|string',
            'user_ids' => 'array',
            'project_ids' => 'array',
        ]);

        $team = Team::findOrFail($id);
        $team->name = $request->name;
        $team->save();

        $team->users()->sync($request->user_ids);
        $team->projects()->sync($request->project_ids);

        return redirect()->route('teams.index')->with('message', 'Equipe atualizada com sucesso!');
    }

    public function delete($id) {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('teams.index')->with('message', 'Time deletado com sucesso!');
    }
}
