<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return $query->get();
    }
}
