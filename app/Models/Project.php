<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'projectCode', 
        'projectName', 
        'clientName', 
        'userID', 
        'startDate', 
        'endDate', 
        'level', 
        'budget', 
        'description',
        'status',
        'progress',
        'type',
        'toggleStar',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
    public function document()
    {
        return $this->hasMany(Document::class, 'projectID');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'projectID');
    }

}

