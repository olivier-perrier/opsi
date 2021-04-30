<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'order'];


    public function fields()
    {
        return $this->hasMany(Field::class); //->orderBy('order');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function authorizations()
    {
        return $this->belongsToMany(Authorization::class, 'authorization_posttype', 'post_type_id', 'authorization_id');
    }
}
