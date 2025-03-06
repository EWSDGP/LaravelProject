<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model {
    use HasFactory;

    protected $primaryKey = 'idea_id';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category_id',
        'is_anonymous',
        'is_enabled',
        'closure_date_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function closureDate() {
        return $this->belongsTo(ClosureDate::class, 'closure_date_id');
    }
   
public function documents()
{
    return $this->hasMany(Document::class, 'idea_id', 'idea_id'); 
}
public function votes()
{
    return $this->hasMany(Vote::class, 'idea_id', 'idea_id');
}
public function comments()
{
    return $this->hasMany(Comment::class, 'idea_id');
}


}
