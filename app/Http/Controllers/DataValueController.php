<?php

namespace App\Http\Controllers;

use App\Models\DataList;
use Illuminate\Http\Request;

class DataValueController extends Controller
{
    public function store(Request $request)
    {

        $dataListId = $request->query("dataList");

        DataList::find($dataListId)->dataValues()->create();

        return back();
    }
}
