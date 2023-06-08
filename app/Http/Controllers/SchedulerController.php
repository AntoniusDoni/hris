<?php

namespace App\Http\Controllers;

use App\Models\Schedules;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Schedules::query();
        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        $query->orderBy('created_at', 'desc');
        return inertia('Schedule/Index', [
            'query' => $query->paginate(10),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_in' => 'required',
            'end_out' => 'required',
        ]);

        Schedules::create([
            'name' => $request->name,
            'start_in'=>$request->start_in.":00",
            'end_out'=>$request->end_out.":00",
        ]);
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function update(Request $request, Schedules $scheduler)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_in' => 'required',
            'end_out' => 'required',
        ]);
        $scheduler->update([
            'name' => $request->name,
            'start_in'=>$request->start_in,
            'end_out'=>$request->end_out,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function destroy(Schedules $scheduler)
    {
        $scheduler->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
