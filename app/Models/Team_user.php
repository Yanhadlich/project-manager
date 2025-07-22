<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team_user extends Model
{
    protected $fillable = [
        'team_id',
        'user_id'
    ];
}
