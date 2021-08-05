<?php

namespace App\Models;

use Jcc\LaravelVote\Traits\Votable;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model implements Viewable
{
    use InteractsWithViews, HasFactory, Votable;

    protected $fillable = [
        'user_id',
        'question_id',
        'text',
        'images'
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
