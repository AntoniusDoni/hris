<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Attendances::query()->with(['employee.division', 'employee.position']);

        if ($request->q != '') {
            $query->whereHas('employee', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")->orWhere('nip', '=', $request->q);
            });
        }

        return inertia('Attendance/Index', [
            'query' => $query->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_at'=>'required',
            'employee_id'=>'required',
            'time_attendance'=>'required',
            'is_attendance'=>'required',
        ]);

        
    }

    public function update(Request $request, Attendances $attendance)
    {
    }

    public function destroy(Attendances $attendance)
    {
    }
}
