<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Divisions;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Divisions::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return $query->get();
    }
}
