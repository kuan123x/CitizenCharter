<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification as NotificationBase;
use Illuminate\Database\Eloquent\Model;

class Notification extends NotificationBase
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
