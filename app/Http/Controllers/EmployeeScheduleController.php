<?php

namespace App\Http\Controllers;

use App\Models\DetailSchedules;
use App\Models\Employees;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = DetailSchedules::query()->with(['employee','division','position'])
        ->join('schedules','schedules.id','=','detail_schedules.schedules_id')
        ->select('detail_schedules.id as id','schedules_id','date','employee_id','division_id','position_id',
        'name',
        'start_in',
        'end_out'
        )->orderBy('date','ASC');
     
        return inertia('EmployeeSchedule/Index', [
            'query' => $query->paginate(10),
        ]);
    }
    

    public function create(Request $request)
    {
        $month = [];
        for ($m = 1; $m <= 12; $m++) {
            $month[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
        return inertia('EmployeeSchedule/Form', ['month' => $month,]);
    }
    public function edit(DetailSchedules $scheduler){
        $month = [];
        for ($m = 1; $m <= 12; $m++) {
            $month[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
        return inertia('EmployeeSchedule/Form', ['month' => $month,'employeeScheduler'=>$scheduler]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'detail_month' => 'required',
            'division_id' => 'required|exists:divisions,id',
            'position_id' => 'required|exists:positions,id',
            'schedules_id' => 'required|exists:schedules,id',
            // 'employee_id' => 'required|exists:employees,id',
        ]);
        $yearnow = date("Y");
        $dateSeleted = Carbon::parse($yearnow . "-" . $request->detail_month . "-01");

        $start = Carbon::create($yearnow . "-" . $request->detail_month . "-01")->startOfMonth();
        $end = Carbon::create($yearnow . "-" . $request->detail_month . "-01")->lastOfMonth();

        $period = CarbonPeriod::between($start, $end)->filter('isWeekday');

        if ($request->is_employee == true) {
            $request->validate(['employee_id' => 'required|exists:employees,id']);
        } else {
            $employees = Employees::where('division_id', $request->division_id)
                ->get();

            DB::beginTransaction();
            try {
                foreach ($employees as $employee) {
                    foreach ($period as $date) {
                        $day = $date->format('Y-m-d');
                        DetailSchedules::create([
                            'schedules_id' => $request->schedules_id,
                            'division_id' => $request->division_id,
                            'employee_id' => $employee->id,
                            'position_id'=>$request->position_id,
                            'date' => $day,
                        ]);
                    }
                }
                DB::commit();
                session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('message', ['type' => 'error', 'message' => 'Item has failed to saved']);
            }
        }
    }
    public function update(DetailSchedules $scheduler)
    {
    }
    public function destroy(DetailSchedules $scheduler)
    {
    }
}
