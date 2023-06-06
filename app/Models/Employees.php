<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employees extends Model
{
    protected $fillable = [
        'name',
        'divison_id',
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

    public function division(){
        return $this->belongsTo(Divisions::class);
    }

    public function position(){
        return $this->belongsTo(Positions::class);
    }
}
