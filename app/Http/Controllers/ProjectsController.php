<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index() {
        return Inertia::render('projects/Index');
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


}
