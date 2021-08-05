<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'start_year',
        'end_year',
        'currently'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
