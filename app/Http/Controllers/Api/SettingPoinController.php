<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SettingPoins;
use Illuminate\Http\Request;

class SettingPoinController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = SettingPoins::query();
        return $query->latest();
    }
}
