<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamDocument extends Model
{
    /** @use HasFactory<\Database\Factories\TeamDocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'team_id',
        'slot',
        'type',
        'file_path',
        'original_name',
        'file_size',
        'content',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'slot' => 'integer',
            'file_size' => 'integer',
        ];
    }

    public function isFile(): bool
    {
        return $this->type === 'file';
    }

    public function isText(): bool
    {
        return $this->type === 'text';
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
