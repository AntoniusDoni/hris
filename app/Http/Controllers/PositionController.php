<?php

namespace App\Http\Controllers;

use App\Models\Positions;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Positions::query();
        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        $query->orderBy('created_at', 'desc');
       
        return inertia('Position/Index', [
            'query' => $query->paginate(10),
        ]);

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Positions::create([
            'name' => $request->name,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);

    }
    public function update(Request $request, Positions $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
          
        ]);

        $position->update([
            'name' => $request->name,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function destroy(Positions $position)
    {
        $position->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
