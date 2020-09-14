<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $fillable = [
        'country_id',
        'title',
        'name',
    ];

    public static function rules()
    {
        $tableCountry = (new Country())->getTable();
        return [
            'country_id' => "required|exists:{$tableCountry},id",
            'title' => "required|string|min:3|max:50",
            'name' => "required|string|min:3|max:50",
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->first();
    }
}
