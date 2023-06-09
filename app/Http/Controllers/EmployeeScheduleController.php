<?php

namespace App\Http\Controllers;

use App\Models\DetailSchedules;
use Illuminate\Http\Request;

class EmployeeScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        $query=DetailSchedules::query();

        return inertia('EmployeeSchedule/Index', [
            'query' => $query->paginate(10),
        ]);
    }

    public function create (Request $request){
        return inertia('EmployeeSchedule/Form', []);
    }
}
