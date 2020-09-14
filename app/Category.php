<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = [
        'title',
        'name',
        'description',
    ];

    public static function rules()
    {
        return [
            'title' => 'required|min:5|max:150',
            'name' => 'required|string|min:3|max:150',
            'description' => 'required|string|min:10|max:250',
        ];
    }

    /**
     * Получить все статьи категории
     * @return Model|null|object|static
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }
}
