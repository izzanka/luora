<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school',
        'primary',
        'degree_type',
        'graduation_year'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
