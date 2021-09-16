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

        // Name of the Post
        $name = $request->input("name");

        // Parent id of the Post
        $parent = $request->input("parent");

        // On of the Data of the Post
        $where = explode(" ", $request->input("where"));
        $whereHas = explode(" ", $request->input("whereHas"));


        $q = "select posts.* ";

        $q = "from posts ";
        if ($request->has("where")) {
            $q .= "join datas on posts.id = datas.post_id ";
            $q .= "join fields on fields.id = datas.field_id ";
        }
        if ($request->has("parent")) {
            $q .= "join posts postsParent on postsParent.id = posts.id ";
        }

        $q .= "where ";
        $q .= "posts.post_type_id = " . $postType->id . " and ";
        if ($request->has("name"))
            $q .= "posts.name = '" . $name . "' and ";
        if ($request->has("where"))
            $q .= "fields.name = '" . $where[0] . "' and datas.value = " . $where[1] . " and ";
        if ($request->has("parent")) {
            $q .= "posts.parent_id = " . $parent . " and ";
        }

        $q .= "true";

        // dd($q);

        // dd(DB::select($q));

        return DB::select($q);
    }
}
