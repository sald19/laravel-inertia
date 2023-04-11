<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'user_id',
        'settings',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
    ];

    protected function settings(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $value = $value ?? '{"document": "default-desde-el-set"}';

                return json_decode($value);
            },
        );
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
        return $this->belongsToMany(Tag::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
