<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team');
    }

    public static function getTeamsWithProjects()
    {
        return self::query()
            ->leftJoin('project_team', 'teams.id', '=', 'project_team.team_id')
            ->leftJoin('projects', 'projects.id', '=', 'project_team.project_id')
            ->select(
                'teams.id as team_id',
                'teams.name as team_name',
                'projects.title as project_name',
                'projects.id as project_id'
            )
            ->get();
    }
}
