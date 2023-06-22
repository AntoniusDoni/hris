<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Employees::query()->with(['division', 'position']);
        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%")->orWhere('nip', '=', $request->q);
        }
        $query->orderBy('created_at', 'desc');

        return inertia('Employee/Index', [
            'query' => $query->paginate(10),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'position_id' => 'required|exists:positions,id',
            'nip' => 'required|string|max:20|min:4|unique:employees,nip',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|max:255',
            'profile_image' => 'nullable|image',
            'phone' => 'nullable|number',
            'address' => 'nullable|string',
            'date_in' => 'required|date',
            'date_out' => 'nullable|date',
            'employee_status' => 'required|string',
            'role_id'=>'required|ulid|exists:roles,id',
        ]);

        $employee=Employees::create([
            'name'=>$request->name,
            'division_id'=>$request->division_id,
            'position_id'=>$request->position_id,
            'nip'=>$request->nip,
            'password'=>bcrypt($request->password),
            'profile_image'=>$request->profile_image,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'date_in'=>$request->date_in,
            'date_out'=>$request->date_out,
            'employee_status'=>$request->employee_status,
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'employee_id'=>$employee->id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function update(Request $request, Employees $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'position_id' => 'required|exists:positions,id',
            'nip' => 'required|string|max:20|min:4',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'password' => 'required|string|max:255',
            'profile_image' => 'nullable|image',
            'phone' => 'nullable|number',
            'address' => 'nullable|string',
            'date_in' => 'required|date',
            'date_out' => 'nullable|date',
            'employee_status' => 'required|string',
            'role_id'=>'required|ulid|exists:roles,id',
        ]);

        $employee->update([
            'name'=>$request->name,
            'division_id'=>$request->division_id,
            'position_id'=>$request->position_id,
            'nip'=>$request->nip,
            'password'=>bcrypt($request->password),
            'profile_image'=>$request->profile_image,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'date_in'=>$request->date_in,
            'date_out'=>$request->date_out,
            'employee_status'=>$request->employee_status,
        ]);

        User::updateOrCreate(['employee_id'=>$employee->id],[
            'email' => $request->email,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'password'=>bcrypt($request->password),
            'employee_id'=>$employee->id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function destroy(Employees $employee)
    {
        $user=User::where('employee_id',$employee->id)->first();
        $user->delete();
        $employee->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
