<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model implements Viewable
{
    use InteractsWithViews,HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'title_slug',
        'link',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function topics(){
        return $this->belongsToMany(Topic::class,'question_topics');
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

}
