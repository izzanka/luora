<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function userVotes(){
        return $this->votes()->one()->where('user_id', auth()->id());
    }

}
