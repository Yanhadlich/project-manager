<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProjectsController extends Controller
{
    public function index() {
        $user = auth()->user();
        $query = Project::with('status:id,name')->active()->latest();
        
        if (!$user->hasRole('Administrador')) {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        $projects = $query->get()->map(function ($project) {
            return [
                'id' => $project->id ?? null,
                'title' => $project->title ?? null,
                'client' => $project->client ?? null,
                'is_active' => $project->is_active ?? null,
                'status_name' => $project->status->name ?? null,
            ];
        });

        return Inertia::render('projects/Index', compact('projects'));
    }

    public function register() {
        return Inertia::render('projects/Create');
    }

    public function create(Request $request) {
        $request->validate([
            'client' => 'required|string',
            'title' => 'required|string',
        ]);

        $project = Project::create([
            'client' => $request->input('client'),
            'title' => $request->input('title'),
            'status_id' => 1,
            'is_active' => true,
        ]);

        $project->users()->attach(auth()->id());

        return redirect()->route('projects.index')->with('message', 'Novo projeto criado com sucesso!');
    }

    public function edit(Project $project) {
        $status = Status::all();
        return Inertia::render('projects/Edit', compact('project', 'status'));
    }

    public function update(Request $request, Project $project) {
        $request->validate([
            'client' => 'required|string',
            'title' => 'required|string',
        ]);

        $project->update([
            'client' => $request->input('client'),
            'title' => $request->input('title'),
            'status_id' => $request->input('status.id'),
            'is_active' => !($request->input('status.name') == "Cancelado"),
        ]);

        return redirect()->route('projects.index')->with('message', 'Projeto atualizado!');
    }

        public function delete(Project $project) {
        $project->update([
            'is_active' => false,
        ]);
        return redirect()->route('projects.index')->with('message', 'Projeto excluido com sucesso!');
    }
}
