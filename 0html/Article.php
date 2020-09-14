<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $fillable = [
//        'category_id',
        'title',
        'name',
        'text',
        'image',
    ];

    public static function rules()
    {
        return [
//            'category_id' => 'required|integer',
            'title' => 'required|string|min:3|max:120',
            'name' => 'required|string|min:3|max:150',
            'text' => 'required|string|min:10',
            'image' => 'required|string|min:3|max:40',
//            'image' => 'mimes:jpeg,bmp,png|max:1000',
        ];
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
