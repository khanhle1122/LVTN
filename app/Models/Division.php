<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $fillable = [ 'divisionName', ];

    public function tasks()
    {
        return $this->belongsTo(Task::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}