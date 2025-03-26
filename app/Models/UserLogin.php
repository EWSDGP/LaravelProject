<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    protected $table = 'user_logins';

    protected $fillable = [
        'user_id',
        'login_date',
        'login_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}