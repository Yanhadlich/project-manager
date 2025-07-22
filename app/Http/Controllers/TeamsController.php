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

    public function edit($id) {
        return Inertia::render('teams/Edit', ['id' => $id]);
    }

    public function update(Request $request, $id) {
        return redirect()->route('teams.index')->with('message', 'Team updated successfully!');
    }

    public function delete($id) {
        return redirect()->route('teams.index')->with('message', 'Team deleted successfully!');
    }
}
