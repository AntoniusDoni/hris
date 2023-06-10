<?php

namespace App\Models;



class DetailSchedules extends Model
{
    protected $fillable = [
        'date',
        'schedules_id',
        'division_id',
        'position_id',
        'employee_id',
    ];

    public function employee(){
        return $this->belongsTo(Employees::class);
    }

    public function division(){
        return $this->belongsTo(Divisions::class);
    }
    public function position(){
        return $this->belongsTo(Positions::class);
    }
    public function schedules(){
        return $this->belongsTo(Schedules::class);
    }
}
