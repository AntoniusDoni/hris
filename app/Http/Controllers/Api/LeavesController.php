<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeavesRequest;
use App\Models\Leaves;

class LeavesController extends Controller
{
    //
    public function store(LeavesRequest $request)
    {
       
            $attendace = Leaves::create(
                [
                    'employee_id'=>$request->employee_id,
                    'date_start'=>$request->date_start,
                    'date_end'=>$request->date_end,
                
                ]
            );
            if ($attendace->exists) {
                return response()->json([
                    'message' => "Cuti Berhasil",
                ]);
             } else {
                return response()->json([
                    'message' => "Cuti Gagal",
                ],201);
             }
    }
}
