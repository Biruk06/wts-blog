<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Post extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable;
    
    protected $fillable = ['user_id', 'title', 'text'];

    protected array $allowedSorts = [ 'id', 'title', 'created_at', 'user.name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}