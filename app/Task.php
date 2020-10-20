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

    public function messages()
    {
        return [
            'date.required' => 'Это поле обязательно для заполнения',
            'date.string'  => 'Это поле должно быть строкой',
            'date.max'  => 'Это поле должно не может быть больше ',
        ];
    }
}
