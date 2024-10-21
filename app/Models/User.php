<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Office;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'office_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Define the relationship with notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function unreadNotifications()
{
    return $this->hasMany(Notification::class)->whereNull('read_at');
}
    public function guest() {
        return $this->hasMany(Office::class);
    }
}
