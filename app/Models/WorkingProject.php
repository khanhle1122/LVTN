<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingProject extends Model
{
    use HasFactory;
    protected $table = 'workings';

    protected $fillable = [
                    'user_id',
                    'project_id',
                    'at_work',
                    'out_work', 
                    'is_work',

                    ];

    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    

}
