<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Divisions extends Model
{
    protected $fillable = [
        'name',
        'division_parent_id',
    ];

    public function parent() {
        return $this->hasOne(Divisions::class,'id','division_parent_id');
    }
    //each category might have multiple children
    public function children() {
        return $this->hasMany(static::class, 'division_parent_id')->orderBy('name', 'asc');
    }
}
