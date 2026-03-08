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
        'manually_marked',
        'sort_order',
        'version',
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
            'manually_marked' => 'boolean',
            'sort_order' => 'integer',
            'version' => 'integer',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
