<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $fillable = [
        'user_id',
        'category_id',
        'title',
        'name',
        'text',
//        'image',
    ];

    public static function rules()
    {
        $tableUser = (new User())->getTable();
        $tableCategory = (new Category())->getTable();
        return [
//            'user_id' => "required|exists:{$tableUser},id",
//            'category_id' => "required|exists:{$tableCategory},id",
            'title' => 'required|min:5|max:150',
            'name' => 'required|string|min:3|max:150',
            'text' => 'required|string|min:10',
//            'image' => 'mimes:jpeg,bmp,png|max:1000'
        ];
    }

    /**
     * Получить пользователя, создавшего категорию
     * @return Model|null|object|static
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->first();
    }

    /**
     * Получить категории статьи
     * @return Model|null|object|static
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->first();
    }
}
