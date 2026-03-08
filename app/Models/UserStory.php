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
        'is_achieved',
        'sort_order',
        'version',
        'manually_created',
        'manually_achieved_at',
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
            'is_achieved' => 'boolean',
            'manually_created' => 'boolean',
            'manually_achieved_at' => 'datetime',
            'sort_order' => 'integer',
            'version' => 'string',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
