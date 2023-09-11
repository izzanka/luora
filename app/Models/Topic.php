<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function questions(){
        return $this->belongsToMany(Question::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
