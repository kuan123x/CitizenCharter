<?php

namespace App\Models;

use App\Events\EventCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'title', 'description', 'status'];
    
    protected $dispatchesEvents = [
        'created' => EventCreated::class,
    ];

    // Scope to filter pending events
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}
