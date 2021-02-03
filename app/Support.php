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
        'client_add_at',
        'manager_add_at',
        'client_view_at',
        'manager_view_at'
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

    public function manager()
    {
        return $this->belongsTo(User::class,'manager_id','id');
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id','id');
    }
}
