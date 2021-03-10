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

    public function fieldDatas()
    {
        return $this->hasMany(Data::class);
    }

    public function relationship_children_posts()
    {
        return $this->hasManyThrough(Post::class, Data::class, 'relationship_id', 'id', 'id', 'post_id');
    }

    public function relationship_children()
    {
        return $this->hasMany(Data::class, 'relationship_id');
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
