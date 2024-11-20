<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coat extends Model
{
    use HasFactory;
    protected $fillable = ['hangmuc', 'description', 'projectID','note','estimated_cost','actual_cost'];

    public function projects()
    {
        return $this->belongsTo(Document::class,'projectID');
    }
}
