<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Attendances::query()
            ->join('employees', 'employees.id', '=', 'attendances.employee_id')
            ->join('divisions', 'divisions.id', '=', 'employees.division_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('attendances.*','nip','employees.name as name','divisions.name as division_name','positions.name as position_name');

        if ($request->q != '') {
            $query->where('name', 'like', "%{$request->q}%")->orWhere('nip', '=', $request->q);
        }

        return inertia('Attendance/Index', [
            'query' => $query->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_at' => 'required',
            'employee_id' => 'required|exists:employees,id',
            'time_attendance' => 'required',
            'is_attendance' => 'required',
        ]);
        
        if ($request->is_attendance === '2') {
            $Attendances = Attendances::updateOrCreate(
                ['date_at' => $request->date_at, 'employee_id' => $request->employee_id],
                [
                    'employee_id' => $request->employee_id,
                    'date_at' => $request->date_at,
                    'time_out' => $request->time_attendance,
                    'is_out' => 1,
                ]
            );
        } else {
            $Attendances = Attendances::updateOrCreate(
                ['date_at' => $request->date_at, 'employee_id' => $request->employee_id],
                [
                    'employee_id' => $request->employee_id,
                    'date_at' => $request->date_at,
                    'time_in' => $request->time_attendance,
                    'is_in' => 1,
                ]
            );
        }

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function update(Request $request, Attendances $attendance)
    {
    }

    public function destroy(Attendances $attendance)
    {
        $attendance->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
