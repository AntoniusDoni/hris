<?php

namespace App\Http\Controllers;

use App\Models\SettingPoins;
use Illuminate\Http\Request;

class SettingPoinController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = SettingPoins::query();

        $query->orderBy('created_at', 'desc');

        return inertia('SettingPoin/Index', [
            'query' => $query->paginate(10),
        ]);

    }
    public function store(Request $request)
    {
        $request->validate([
            'long' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
        ]);

        SettingPoins::create([
            'long' => $request->long,
            'lat' => $request->lat,
            'is_location'=>$request->is_location,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);

    }
    public function update(Request $request, SettingPoins $settingPoin)
    {
        $request->validate([
            'long' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
        ]);

        $settingPoin->update([
            'long' => $request->long,
            'lat' => $request->lat,
            'is_location'=>$request->is_location
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
    public function destroy(SettingPoins $settingPoin)
    {
        $settingPoin->delete();
        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
