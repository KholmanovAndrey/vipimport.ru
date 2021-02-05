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
        'phone',
        'status_id',
        'tracker',
        'price'
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

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class,'manager_id','id');
    }

    public function client()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function supports()
    {
        return $this->hasMany(Support::class, 'parcel_id', 'id');
    }
}
