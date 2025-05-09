<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function ideas()
    {
        return $this->hasManyThrough(Idea::class, User::class, 'department_id', 'user_id', 'id', 'id');
    }
}