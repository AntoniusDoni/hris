<?php

namespace App\Models;


class Leaves extends Model
{
    protected $fillable = [
        'employee_id','date_start','date_end','is_approve','responsible_empoyee_id'
    ];
}
