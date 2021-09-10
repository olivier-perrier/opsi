<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table ='datas';

    protected $fillable = ['value', 'post_id', 'field_id', 'order'];

    protected $casts = [
        // 'value_json' => 'array',
        // 'value_json' => 'collection',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function relatedPost()
    {
        return $this->belongsTo(Post::class, 'relationship_id');
    }

    public function relatedField()
    {
        return $this->belongsTo(Field::class);
    }

    public function dataList()
    {
        return $this->hasOne(DataList::class);
    }

    public function dataRelationship()
    {
        return $this->hasOne(DataRelationship::class);
    }

  
}
