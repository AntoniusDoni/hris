<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class Employees extends Authenticatable implements JWTSubject
{
    // use HasFactory, Notifiable;
    use Notifiable;

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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
