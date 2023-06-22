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
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',

    ];

    public function attendance(){
        return $this->hasOne(Attendances::class,'employee_id','id');
    }

    public function division(){
        return $this->belongsTo(Divisions::class);
    }

    public function position(){
        return $this->belongsTo(Positions::class);
    }
    public function user(){
        return $this->hasOne(User::class,'employee_id');
    }

}
