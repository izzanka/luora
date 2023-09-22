<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function topics(){
        return $this->belongsToMany(Topic::class);
    }

    public function spaces(){
        return $this->hasMany(Space::class);
    }

    public function education(){
        return $this->hasOne(Education::class);
    }

    public function employment(){
        return $this->hasOne(Employment::class);
    }

    public function location(){
        return $this->hasOne(Location::class);
    }
}
