<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $fillable = [
        'title',
        'table_name'
    ];

    public static function rules()
    {
        return [
            'title' => "required|string|min:3|max:50",
            'table_name' => 'required|string|min:3|max:50',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }
}
