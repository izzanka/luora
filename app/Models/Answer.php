<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model implements Viewable
{
    use HasFactory, InteractsWithViews;

    protected $removeViewsOnDelete = true;

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answerVotes()
    {
        return $this->hasMany(AnswerVote::class);
    }

    public function userAnswerVotes()
    {
        return $this->answerVotes()->one()->where('user_id', auth()->id());
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
