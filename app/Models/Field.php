<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'order'];

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function datas()
    {
        return $this->hasMany(Data::class);
    }

    public function data($post)
    {
        return $this->hasOne(Data::class)->where("post_id", $post->id)->first();
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class, 'posttype_id');
    }
}
