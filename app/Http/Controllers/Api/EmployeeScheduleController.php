<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailSchedules;
use Illuminate\Http\Request;

class EmployeeScheduleController extends Controller
{
    //
    public function index(Request $request){
        if($request->date_at==""||$request->employee_id==""){
            return response()->json([
                'message' => "Request invalid",
            ], 400);
        }
        $employeeSchedule=DetailSchedules::where(['date' => $request->date_at, 'employee_id' => $request->employee_id])
        ->join('schedules', 'schedules.id', '=', 'detail_schedules.schedules_id')
        ->select('employee_id',
        'date',
        'schedules_id',
        'name',
        'start_in',
        'end_out')

        ->first();
        if (!empty($employeeSchedule)) {
            return response()->json([
                'message' => "Jadwal Pegawai",
                'schedule' => $employeeSchedule,
            ]);
        }else{
            return response()->json([
                'message' => "Jadwal Pegawai Tidak Ditemukan",
                'schedule' => $employeeSchedule,
            ],201);
        }
    }
}
