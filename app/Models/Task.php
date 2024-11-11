<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
                    'task_name', 
                    'task_code',
                    'note',
                    'startDate',
                    'endDate',
                    'status',
                    'parentID', 
                    'projectID',
                    'userID',
                    'budget',
                    'progress',
                    'duration',
                    'star'
                    ];

    public function projects()
    {
        return $this->belongsTo(Project::class,'projectID');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'userID');
    }
  

}
