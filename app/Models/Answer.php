<?php

namespace App\Models;

use Jcc\LaravelVote\Traits\Votable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model implements Viewable
{
    use InteractsWithViews, HasFactory, Votable, SoftDeletes;

    protected $removeViewsOnDelete = true;

    protected $guarded = [];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function report_users(){
        return $this->belongsToMany(User::class,'report_answers')->withPivot('type');
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }

}
