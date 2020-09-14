<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $fillable = [
        'user_id',
        'country_id',
        'city_id',
    ];

    public static function rules()
    {
        $tableUser = (new User())->getTable();
        $tableCity = (new City())->getTable();
        $tableCountry = (new Country())->getTable();
        return [
            'user_id' => "required|exists:{$tableUser},id",
            'city_id' => "required|exists:{$tableCity},id",
            'country_id' => "required|exists:{$tableCountry},id",
        ];
    }
}
