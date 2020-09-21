<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelOrder extends Model
{
    public $fillable = [

    ];

    public static function rules()
    {
        return [

        ];
    }

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}
