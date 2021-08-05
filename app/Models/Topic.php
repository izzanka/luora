<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'qty'
    ];

    public function questions(){
        return $this->belongsToMany(Question::class,'question_topics');
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_topics');
    }
}
