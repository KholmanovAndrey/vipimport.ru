<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'title',
        'count',
        'link',
        'price',
        'color',
        'size',
        'description',
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string|min:3|max:50',
            'count' => 'required|integer',
            'link' => 'string|min:3|max:50',
            'price' => 'float',
            'color' => 'string',
            'size' => 'string',
            'description' => 'required|string|min:10|max:250',
        ];
    }
}
