<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'company',
        'start_year',
        'end_year',
        'currently'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
