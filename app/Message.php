<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $fillable = [
        'message',
        'user_id',
        'support_id',
    ];

    public static function rules()
    {
        return [
            'message' => 'required|string|min:10',
        ];
    }
}
