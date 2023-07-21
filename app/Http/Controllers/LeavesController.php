<?php

namespace App\Http\Controllers;

use App\Models\Leaves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $query=Leaves::query()->with(['employee','employee.division','employee.position','responsibleEmployee']);
        if($user?->role?->name!="admin"){
            $query->where('employee_id','=',$user->employee_id);
        }
        $query->whereHas('employee', function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")->orWhere('nip', '=', $request->q);
        });
        return inertia('Leaves/Index', [
            'query' => $query->paginate(10),
        ]);
    }
    public function update(Request $request,Leaves $leave){
        $request->validate([
            'date_start' => 'required|date',
            'date_end' => 'nullable|date',
            'responsible_empoyee_id'=>'required|exists:employees,id',
        ]);
        $leave->update([
            'date_start'=>$request->date_start,
            'date_end'=>$request->date_end,
            'responsible_empoyee_id'=>$request->responsible_empoyee_id,
        ]);
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
}
