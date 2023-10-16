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

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // public function topics()
    // {
    //     return $this->hasMany(Topic::class);
    // }

    // public function spaces()
    // {
    //     return $this->hasMany(Space::class);
    // }

    public function education()
    {
        return $this->hasOne(Education::class);
    }

    public function employment()
    {
        return $this->hasOne(Employment::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function userFollow($user_id)
    {
        if (! $this->userIsFollowing($user_id)) {
            UserFollow::create([
                'user_id' => auth()->id(),
                'following_id' => $user_id,
            ]);
        }
    }

    public function userUnfollow($user_id)
    {
        if ($this->userIsFollowing($user_id)) {
            UserFollow::where('user_id', auth()->id())->where('following_id', $user_id)->delete();
        }
    }

    public function userIsFollowing($user_id)
    {
        return $this->userFollowing()->where('users.id', $user_id)->exists();
    }

    public function userFollowing()
    {
        return $this->hasManyThrough(User::class, UserFollow::class, 'user_id', 'id', 'id', 'following_id');
    }

    public function userFollowers()
    {
        return $this->hasManyThrough(User::class, UserFollow::class, 'following_id', 'id', 'id', 'user_id');
    }

    public function topicFollow($topic_id)
    {
        if (! $this->topicIsFollowing($topic_id)) {
            TopicFollow::create([
                'user_id' => auth()->id(),
                'topic_id' => $topic_id,
            ]);
        }
    }

    public function topicUnfollow($topic_id)
    {
        if ($this->topicIsFollowing($topic_id)) {
            TopicFollow::where('user_id', auth()->id())->where('topic_id', $topic_id)->delete();
        }
    }

    public function topicIsFollowing($topic_id)
    {
        return $this->topicFollowing()->where('topics.id', $topic_id)->exists();
    }

    public function topicFollowing()
    {
        return $this->hasManyThrough(Topic::class, TopicFollow::class, 'user_id', 'id', 'id', 'topic_id');
    }

    public function topicFollowers()
    {
        return $this->hasManyThrough(Topic::class, TopicFollow::class, 'topic_id', 'id', 'id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
