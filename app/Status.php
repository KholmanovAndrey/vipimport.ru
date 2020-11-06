<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $fillable = [
        'title',
        'table_name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }
}
