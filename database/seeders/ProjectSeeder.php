<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach (range(1, 10) as $i) {
            $project = Project::create([
                'title' => 'Projeto ' . $i,
                'client' => 'Cliente ' . $i,
                'status_id' => rand(1, 3),
                'is_active' => true,
                'user_id' => $users->random()->id,
            ]);

            // $participants = $users->random(rand(1, 3))->pluck('id');
            // $project->users()->attach($participants);
        }
    }
}
