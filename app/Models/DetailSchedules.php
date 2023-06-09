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
        return $this->hasMany(Employees::class);
    }

    public function division(){
        return $this->hasMany(Divisions::class);
    }
    public function position(){
        return $this->hasMany(Positions::class);
    }
}
