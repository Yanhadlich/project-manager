<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamsController extends Controller
{
    public function index() {
        Inertia::render('teams/Index');
    }

    public function create() {
        return Inertia::render('teams/Create');
    }

    public function register() {
        
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
