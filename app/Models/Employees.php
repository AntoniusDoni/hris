<?php

namespace App\Models;



class Employees extends Model
{
    protected $fillable = [
        'name',
        'division_id',
        'position_id',
        'nip',
        'password',
        'profile_image',
        'email',
        'phone',
        'address',
        'date_in',
        'date_out',
        'employee_status',
    ];
    protected $table="employees";

    public function attendance(){
        return $this->hasOne(Attendances::class,'employee_id','id');
    }

    public function division(){
        return $this->belongsTo(Divisions::class);
    }

    public function position(){
        return $this->belongsTo(Positions::class);
    }

}
