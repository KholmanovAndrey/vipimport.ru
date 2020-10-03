<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    public $fillable = [
        'title',
        'client_id',
        'manager_id',
        'order_id',
        'parcel_id',
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string|min:3|max:150',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'support_id', 'id');
    }
}
