<?php

namespace App\Models;

use App\Enums\UserStoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStory extends Model
{
    /** @use HasFactory<\Database\Factories\UserStoryFactory> */
    use HasFactory;

    protected $fillable = [
        'team_id',
        'title',
        'description',
        'keywords',
        'status',
        'is_covered',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => UserStoryStatus::class,
            'keywords' => 'array',
            'is_covered' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
