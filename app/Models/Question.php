<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

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
