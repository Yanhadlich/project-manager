<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index() {
        return Inertia::render('projects/Index');
    }

    public function create() {
        //
    }

    public function update() {
        //
    }
    
    public function delete() {
        //
    }
}
