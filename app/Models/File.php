<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['fileName', 'filePath', 'documentID','status'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    
}
