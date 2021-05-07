<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataValue extends Model
{
    use HasFactory;

    protected $fillable = ['value'];


    public function data()
    {
        return $this->belongsTo(Data::class);
    }

    public function dataList()
    {
        return $this->belongsTo(DataList::class);
    }
}
