<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $fillable = [
        'title',
        'name',
    ];

    public static function rules()
    {
        return [
            'title' => "required|string|min:3|max:50",
            'name' => "required|string|min:3|max:50",
        ];
    }

    /**
     * Получить города данной страны
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }
}
