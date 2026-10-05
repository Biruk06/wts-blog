<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use HasFactory, SoftDeletes, AsSource;
    
    protected $fillable = ['user_id', 'title', 'text'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}