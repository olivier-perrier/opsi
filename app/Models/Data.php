<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'field_id', 'value', 'value_json', 'relationship_id', 'related_field_id', 'order'];

    protected $casts = [
        // 'value_json' => 'array',
        // 'value_json' => 'collection',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function relatedPost()
    {
        return $this->belongsTo(Post::class, 'relationship_id');
    }

    public function relatedField()
    {
        return $this->belongsTo(Field::class);
    }

  
}
