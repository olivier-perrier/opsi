<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['post_type_id', 'name', 'content', 'parent_id', 'user_id'];

    protected $casts = [
        'content' => 'array',
        // 'content' => AsArrayObject::class,
    ];

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }

    public function datas()
    {
        return $this->hasMany(Data::class); //->orderBy('order');
    }

    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(Post::class);
    }

    public function find($postId)
    {
        return Post::all()->where('id', $postId)->first();
    }

    public function getDataForFieldName($fieldName)
    {
        $field = $this->posttype->fields->where('name', $fieldName)->first();

        if ($field)
            return $this->datas->where('field_id', $field->id)->first();
        else return;
    }

    public function relationships()
    {
        return $this->hasMany(DataRelationship::class);
    }
}
