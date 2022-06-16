<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tags::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
