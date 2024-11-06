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
                    'budget',
                    'progress',
                    'divisionID',
                    'duration'
                    ];

    public function projects()
    {
        return $this->belongsTo(Project::class,'projectID');
    }
    public function divisions()
    {
        return $this->belongsTo(Division::class);
    }
  

}
