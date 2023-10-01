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

    public function follow($user_id) {
        if(!$this->isFollowing($user_id)) {
            Follow::create([
                'user_id' => auth()->id(),
                'following_id' => $user_id
            ]);
        }
    }

    public function unfollow($user_id) {
        if($this->isFollowing($user_id)){
            Follow::where('user_id', auth()->id())->where('following_id', $user_id)->delete();
        }
    }

    public function isFollowing($user_id) {
        return $this->following()->where('users.id', $user_id)->exists();
    }

    public function following() {
        return $this->hasManyThrough(User::class, Follow::class, 'user_id', 'id', 'id', 'following_id');
    }

    public function followers() {
        return $this->hasManyThrough(User::class, Follow::class, 'following_id', 'id', 'id', 'user_id');
    }
}
