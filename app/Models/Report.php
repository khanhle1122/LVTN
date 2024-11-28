<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';

    protected $fillable = [
                    'comment',
                    'is_pass',
                    'user_id',
                    'project_id', 
                    'totalCoat'
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
