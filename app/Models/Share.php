<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
