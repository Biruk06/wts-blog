<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    // Разрешаем массовое заполнение этих полей при создании поста
    protected $fillable = ['user_id', 'title', 'text'];

    // Указываем обратную связь: пост принадлежит пользователю (автору)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}