<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'authorization_id', 'posttype_id'];


    public function posttypes()
    {
        return $this->belongsToMany(Posttype::class, 'authorization_posttype', 'authorization_id', 'posttype_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class); //, 'authorization_posttype', 'authorization_id', 'posttype_id');
    }

}
