<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    use HasFactory;

    protected $table = 'posttypes';

    protected $fillable = ['name', 'order'];


    public function fields()
    {
        return $this->hasMany(Field::class, 'posttype_id')->orderBy('order');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'posttype_id');
    }
    
}
