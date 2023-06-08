<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedules extends Model
{
    protected $fillable = [
        'name',
        'start_in',
        'end_out'
    ];
}
