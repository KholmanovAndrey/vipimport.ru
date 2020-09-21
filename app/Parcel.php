<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    public $fillable = [
        'title',
        'description',
        'fio',
        'address',
        'phone'
    ];

    public static function rules()
    {
        return [

        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'parcel_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
