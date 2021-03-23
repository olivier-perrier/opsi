<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['posttype', 'name', 'content', 'parent_id'];

    protected $casts = [
        'content' => 'array',
    ];

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }

    public function datas()
    {
        return $this->hasMany(Data::class);
    }

    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }
}
