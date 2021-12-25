<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model implements Viewable
{
    use InteractsWithViews, HasFactory, SoftDeletes;

    protected $removeViewsOnDelete = true;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function topics(){
        return $this->belongsToMany(Topic::class,'question_topics');
    }

    public function report_users(){
        return $this->belongsToMany(User::class,'report_questions')->withPivot('type');
    }
}
