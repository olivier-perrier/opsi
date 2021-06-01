<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'authorization_id', 'posttype_id'];


    public function postTypes()
    {
        return $this->belongsToMany(Posttype::class, 'authorization_posttype', 'authorization_id', 'post_type_id')->orderBy('name');
    }

    public function authorizationPosttypes()
    {
        return $this->hasMany(AuthorizationPosttype::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
