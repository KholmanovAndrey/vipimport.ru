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
        'isDeleted'
    ];

    public static function rules()
    {
        return [
            'title' => 'required|string|min:3|max:50',
            'count' => 'required|integer',
            'description' => 'required|string|min:3|max:250',
        ];
    }

    public static function rulesArray()
    {
        return [
            'title.*' => 'required|string|min:3|max:50',
            'count.*' => 'required|integer',
            'description.*' => 'required|string|min:3|max:250',
        ];
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class,'manager_id','id');
    }
}
