<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function posts()
    {
        return $this->users->flatMap(function($user) {
            return $user->posts;
        });
    }

    public function postTypes()
    {
        return $this->hasMany(PostType::class);
    }
}
