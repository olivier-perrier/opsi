<?php

namespace App\Http\Controllers;

use App\Models\DataList;
use App\Models\DataValue;
use Illuminate\Http\Request;

class DataListController extends Controller
{

    public function edit(DataList $dataList)
    {
        return view('dataList.edit', ['dataList' => $dataList]);
    }

    public function update(DataList $dataList, Request $request)    
    {
        foreach ($request['inputs'] as $inputId => $inputValue) {
            DataValue::find($inputId)->update(['value' => $inputValue]);
        }
        // dd($request['inputs']);
        return back();
    }
}
