<?php

namespace App\Models;


class Attendances extends Model
{
    protected $fillable = [
        'employee_id',
        'date_at',
        'time_in',
        'time_out',
        'is_in',
        'is_out',
        'lat',
        'long',
    ];
}
