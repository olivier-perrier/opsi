<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataList extends Model
{
    use HasFactory;

    protected $fillable = ['data_id'];

    public function dataValues()
    {
        return $this->hasMany(DataValue::class);
    }

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
