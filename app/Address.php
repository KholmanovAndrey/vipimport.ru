<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $fillable = [
        'user_id',
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

    public static function rulesCreate()
    {
        $tableUser = (new User())->getTable();
        $tableCountry = (new Country())->getTable();
        return [
            'user_id' => "required|exists:{$tableUser},id",
            'firstname' => 'required|string|min:3|max:50',
            'lastname' => 'required|string|min:3|max:50',
            'othername' => 'nullable|string|max:50',
            'country_id' => "required|exists:{$tableCountry},id",
            'postal_code' => 'required|string|max:50',
            'region' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'street' => 'required|string|max:50',
            'building' => 'required|string|max:50',
            'body' => 'nullable|string|max:50',
            'apartment' => 'nullable|string|max:50',
            'phone' => 'required|string|min:3|max:50',
        ];
    }

    public static function rulesUpdate()
    {
        $tableCountry = (new Country())->getTable();
        return [
            'firstname' => 'required|string|min:3|max:50',
            'lastname' => 'required|string|min:3|max:50',
            'othername' => 'nullable|string|max:50',
            'country_id' => "required|exists:{$tableCountry},id",
            'postal_code' => 'required|string|max:50',
            'region' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'street' => 'required|string|max:50',
            'building' => 'required|string|max:50',
            'body' => 'nullable|string|max:50',
            'apartment' => 'nullable|string|max:50',
            'phone' => 'required|string|min:3|max:50',
        ];
    }

    static public function messages()
    {
        return [
            'required' => 'Это поле обязательно для заполнения',
            'string'  => 'Это поле должно быть строкой',
            'max'  => 'Это поле должно не может быть больше ',
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
