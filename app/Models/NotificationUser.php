<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;
    protected $table = 'notification_user';

    protected $fillable = [
        'user_id',
        'notification_id',
        'is_read',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Notification
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
