<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $fillable = [
        'firstname',
        'lastname',
        'othername',
        'country_id',
        'email',
        'phone',
    ];

    public static function rules()
    {
        $tableCountry = (new Country())->getTable();
        return [
            'firstname' => 'required|string|min:3|max:50',
            'lastname' => 'required|string|min:3|max:50',
            'othername' => 'required|string|min:3|max:50',
            'country_id' => "required|exists:{$tableCountry},id",
            'email' => 'required|email',
            'phone' => 'required|string|min:3|max:50',
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
