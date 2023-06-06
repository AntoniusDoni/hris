<?php

namespace App\Http\Controllers;

use App\Models\Divisions;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Divisions::query()->with(['parent']);
        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        $query->orderBy('created_at', 'desc');
       
        return inertia('Division/Index', [
            'query' => $query->paginate(10),
        ]);

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_parent_id' => 'nullable|exists:divisions,id',
        ]);

        Divisions::create([
            'name' => $request->name,
            'division_parent_id' => $request->division_parent_id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);

    }
    public function update(Request $request, Divisions $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division_parent_id' => 'nullable|exists:divisions,id',
        ]);

        $division->update([
            'name' => $request->name,
            'division_parent_id' => $request->division_parent_id,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function destroy(Divisions $division)
    {
        $division->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
