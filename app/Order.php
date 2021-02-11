<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'user_id',
        'title',
        'count',
        'link',
        'price',
        'color',
        'size',
        'description',
        'isDeleted',
        'isPaid',
        'receipt'
    ];

    public static function rules()
    {
        $tableUser = (new User())->getTable();
        return [
            'user_id' => "required|exists:{$tableUser},id",
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

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}
