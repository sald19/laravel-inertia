<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function searchableAs(): string
    {
        return 'posts_index';
    }

    public function toSearchableArray(): array
    {
        return $this->only(['user_id', 'title', 'content']);
    }

    public static function getSearchFilterAttributes(): array
    {
        return [
            'user_id',
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tags::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
