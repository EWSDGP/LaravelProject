<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $table = 'votes'; 

    protected $fillable = [
        'idea_id',
        'user_id',
        'vote_type',
    ];

    
    public function idea()
    {
        return $this->belongsTo(Idea::class, 'idea_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

