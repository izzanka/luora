<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function questions(){
        return $this->belongsToMany(Question::class,'question_topics');
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_topics');
    }
}
