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
            'fio' => "required|string|min:3|max:150",
            'address' => "required|string|min:3|max:1000",
            'phone' => 'required|string|min:3|max:50',
        ];
    }

    public function parcelOrders()
    {
        return $this->hasMany(ParcelOrder::class, 'parcel_id', 'id');
    }
}
