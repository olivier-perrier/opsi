<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizationPosttype extends Model
{
    use HasFactory;

    protected $table = "authorization_posttype";

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }
}
