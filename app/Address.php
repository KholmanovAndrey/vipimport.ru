<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $fillable = [
        'firstname',
        'lastname',
        'othername',
        'country_id',
        'postal_code',
        'region',
        'city',
        'street',
        'building',
        'body',
        'apartment',
        'phone'
    ];

    public static function rules()
    {
        $tableCountry = (new Country())->getTable();
        return [
            'firstname' => 'required|string|min:3|max:50',
            'lastname' => 'required|string|min:3|max:50',
            'othername' => 'required|string|min:3|max:50',
            'country_id' => "required|exists:{$tableCountry},id",
            'postal_code' => 'required|string|min:1|max:50',
            'region' => 'required|string|min:1|max:50',
            'city' => 'required|string|min:1|max:50',
            'street' => 'required|string|min:1|max:50',
            'building' => 'required|string|min:1|max:50',
            'phone' => 'required|string|min:3|max:50',
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
