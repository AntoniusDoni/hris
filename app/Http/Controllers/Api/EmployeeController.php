<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Employees::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%")->orWhere('nip','=',$request->q);
        }

        return $query->get();
    }
}
