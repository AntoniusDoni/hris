<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendaceRequest;
use App\Models\Attendances;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //

    public function stroreIn(AttendaceRequest $request)
    {
       
            $attendace = Attendances::create(
                [
                    'employee_id' => $request->employee_id,
                    'date_at' => $request->date_at,
                    'time_in' => $request->time_attendance,
                    'is_in' => 1,
                ]
            );
            if ($attendace->exists) {
                return response()->json([
                    'message' => "Absensi Berhasil",
                ]);
             } else {
                return response()->json([
                    'message' => "Absensi Gagal",
                ],201);
             }
    }
    public function stroreOut(AttendaceRequest $request)
    {
      
            $attendace = Attendances::where(['date_at' => $request->date_at, 'employee_id' => $request->employee_id])->update(
                [
                    'employee_id' => $request->employee_id,
                    'date_at' => $request->date_at,
                    'time_out' => $request->time_attendance,
                    'is_out' => 2,
                ]
            );
        
            if ($attendace) {
                return response()->json([
                    'message' => "Absensi Berhasil",
                ]);
             } else {
                return response()->json([
                    'message' => "Absensi Gagal",
                ],201);
             }
    }
    public function GetAttendace(Request $request){
        if($request->date_at==""||$request->employee_id==""){
            return response()->json([
                'message' => "Request invalid",
            ], 400);
        }

        $attendace=Attendances::where(['date_at' => $request->date_at, 'employee_id' => $request->employee_id])->first();
        if (!empty($attendace)) {
            return response()->json([
                'message' => "Data Abensi Masuk ",
                'flag' => '2',
                'attendace' => $attendace,
            ]);
        } else {
            return response()->json([
                'message' => "Belum Ada Absensi hari ini",
                'flag' => '1'
            ], 201);
        }

    }
}