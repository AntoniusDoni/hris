<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Employees::query()->with(['disivion', 'position']);
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
            'divison_id' => 'required|exists:divisions,id',
            'position_id' => 'required|exists:positions,id',
            'nip' => 'required|string|max:20|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
            'profile_image' => 'nullable|image',
            'phone' => 'nullable|number',
            'address' => 'nullable|string',
            'date_in' => 'required|date',
            'date_out' => 'required|date',
            'employee_status' => 'required|string',
        ]);
       
        Employees::create([
            'name'=>$request->name,
            'divison_id'=>$request->name,
            'position_id'=>$request->name,
            'nip'=>$request->name,
            'password'=>bcrypt($request->password),
            'profile_image'=>$request->profile_image,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'date_in'=>$request->date_in,
            'date_out'=>$request->date_out,
            'employee_status'=>$request->employee_status,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function update(Request $request, Employees $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'divison_id' => 'required|exists:divisions,id',
            'position_id' => 'required|exists:positions,id',
            'nip' => 'required|string|max:20|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
            'profile_image' => 'nullable|image',
            'phone' => 'nullable|number',
            'address' => 'nullable|string',
            'date_in' => 'required|date',
            'date_out' => 'required|date',
            'employee_status' => 'required|string',
        ]);

        $employee->update([
            'name'=>$request->name,
            'divison_id'=>$request->name,
            'position_id'=>$request->name,
            'nip'=>$request->name,
            'password'=>bcrypt($request->password),
            'profile_image'=>$request->profile_image,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'date_in'=>$request->date_in,
            'date_out'=>$request->date_out,
            'employee_status'=>$request->employee_status,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function destroy(Employees $employee)
    {
        $employee->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
