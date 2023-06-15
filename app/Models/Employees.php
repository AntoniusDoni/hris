<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employees extends Authenticatable implements JWTSubject
{
    // use HasFactory, Notifiable;
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

    public function attendance(){
        return $this->hasOne(Attendances::class,'employee_id','id');
    }

    public function division(){
        return $this->belongsTo(Divisions::class);
    }

    public function position(){
        return $this->belongsTo(Positions::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
