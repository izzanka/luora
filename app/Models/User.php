<?php

namespace App\Models;

use Jcc\LaravelVote\Traits\Voter;
use Overtrue\LaravelFollow\Followable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Followable, Voter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_slug',
        'description',
        'credential',
        'email',
        'password',
        'provider_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function topics(){
        return $this->belongsToMany(Topic::class,'user_topics');
    }

    public function getContents(){
        $questions = $this->questions()->latest()->get();
        $answers = $this->answers()->latest()->get();

        return $questions->merge($answers);
    }

    public function employment(){
        return $this->hasOne(Employment::class);
    }

    public function education(){
        return $this->hasOne(Education::class);
    }

    public function location(){
        return $this->hasOne(Location::class);
    }

    public function report_questions(){
        return $this->belongsToMany(Question::class,'report_questions');
    }

    public function report_answers(){
        return $this->belongsToMany(Answer::class,'report_answers');
    }
}
