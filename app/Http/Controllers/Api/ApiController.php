<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function index(Request $request, PostType $postType)
    {

        // dd($request->input("where"));
        $where = explode(" ", $request->input("where"));
        $whereHas = explode(" ", $request->input("whereHas"));
        // dd($whereHas);

        // return DB::select("select * from posts join where ");
        // $a = ["post_id", 1];
        // dd($postType->posts()->where($where[0], $where[1], $where[2]));
        // return $postType->posts()->where($where[0], $where[1], $where[2])->get();

        // dd($postType->posts);

        // dd($postType->posts->first()->datas);

        // return $postType->posts()->whereHas($whereHas[0], function(Builder $query) use ($whereHas){


            $q = "select * " .
            "from posts " .
            "join datas on posts.id = datas.post_id " .
            "join fields on fields.id = datas.field_id ".
            "where fields.name = ? and datas.value = ? ";

            // dd($q);

            // dd(DB::select($q));

            return DB::select($q, $whereHas);
        // return $postType->posts()->whereHas('datas', function (Builder $query) use ($whereHas) {
        //     // dd($request);
        //     // $query->where('value', $whereHas[2], $whereHas[3])->get()

        //     $field_id = $query->fields()->where('name', '=', 'X');

        //     dd($field_id);
        //     $query->where('value', '=', '200')
        //         ->where('field_id',  '=', $field_id);

        // })->whereHas('fields', function (Builder $query) use ($whereHas) {

                
        //         // ->where('value', $whereHas[2], $whereHas[3]);

        //     })
        //     ->get();
    }
}
