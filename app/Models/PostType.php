<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'order', 'hidden', 'organization_id'];

    protected $attributes = [
        'hidden' => false,
    ];


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

    public function authorizationsPosttypes()
    {
        return $this->hasMany(AuthorizationPosttype::class);
    }

}
