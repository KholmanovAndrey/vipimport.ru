<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $fillable = [
        'title',
        'address',
        'phone',
        'email',
        'description',
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string|min:5|max:150',
            'address' => 'required|string|min:3|max:150',
            'phone' => 'required|string|min:3|max:150',
            'email' => 'required|email|min:3|max:150',
            'description' => 'nullable|string|min:10',
        ];
    }
}
