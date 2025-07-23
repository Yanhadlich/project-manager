<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'client', 'status_id', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'project_team');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}
