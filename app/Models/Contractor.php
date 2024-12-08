<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','phone','address','status','email','contactorCode'
    ];
    public function projects()
    {
        return $this->hasMany(Project::class, 'clientID');
    }
}
