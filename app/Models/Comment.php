<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function report_users(){
        return $this->belongsToMany(User::class,'report_comments')->withPivot('type');
    }
    
    // public function replies(){
    //     return $this->hasMany(Comment::class, 'parent_id');
    // }

    // public function answer(){
    //     return $this->belongsTo(Answer::class);
    // }

    
}
