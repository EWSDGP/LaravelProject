<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'idea_id',
        'file_path',
    ];

    
   

public function idea()
{
    return $this->belongsTo(Idea::class, 'idea_id', 'idea_id'); 
}

}
