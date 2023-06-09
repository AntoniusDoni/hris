<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedules;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Schedules::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return $query->get();
    }
}
