<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProjectsController extends Controller
{
    public function index() {
        $projects = Projects::active()->latest()->get();
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

        Projects::create([
            'client' => $request->input('client'),
            'title' => $request->input('title'),
            'status_id' => 1,
            'is_active' => true,
        ]);

        return redirect()->route('projects.index')->with('message', 'Novo projeto criado com sucesso!');
    }

    public function edit(Projects $project) {
        $status = Status::all();
        return Inertia::render('projects/Edit', compact('project', 'status'));
    }

    public function update(Request $request, Projects $project) {
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

        public function delete(Projects $project) {
        $project->update([
            'is_active' => false,
        ]);
        return redirect()->route('projects.index')->with('message', 'Projeto excluido com sucesso!');
    }
}
