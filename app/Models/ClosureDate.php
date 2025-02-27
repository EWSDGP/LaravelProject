<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosureDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'Idea_ClosureDate', 
        'Comment_ClosureDate', 
        'Academic_Year'
    ];
}
