<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repository extends Model
{
    /** @use HasFactory<\Database\Factories\RepositoryFactory> */
    use HasFactory;

    protected $fillable = [
        'team_id',
        'github_owner',
        'github_repo',
        'full_name',
        'default_branch',
        'description',
        'is_active',
        'last_synced_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function commits(): HasMany
    {
        return $this->hasMany(Commit::class);
    }
}
