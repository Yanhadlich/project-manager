<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project_team extends Model
{
    protected $fillable = [
        'project_id',
        'team_id'
    ];
}
