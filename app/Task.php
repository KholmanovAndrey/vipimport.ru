<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'solution'
    ];

    static public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'solution' => 'required|string',
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
}
