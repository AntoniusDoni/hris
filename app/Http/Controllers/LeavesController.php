<?php

namespace App\Http\Controllers;

use App\Models\Leaves;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
    //

    public function index(Request $request){
        $query=Leaves::query()->with(['employee','employee.division','employee.position']);
        $query->whereHas('employee', function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")->orWhere('nip', '=', $request->q);
        });
        return inertia('Leaves/Index', [
            'query' => $query->paginate(10),
        ]);
    }
}
