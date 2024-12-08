<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskWork extends Model
{
    use HasFactory;
    protected $table = 'taskworkings';
    protected $fillable = [
        'division_id',
        'task_id',
        'at_work',
        'out_work', 
        'is_work',

        ];
        public function tasks()
    {
        return $this->belongsTo(Task::class,'task_id');
    }
    public function divisions()
    {
        return $this->belongsTo(Division::class,'division_id');
    }
    
}
