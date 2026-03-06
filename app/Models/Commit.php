<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commit extends Model
{
    /** @use HasFactory<\Database\Factories\CommitFactory> */
    use HasFactory;

    protected $fillable = [
        'repository_id',
        'sha',
        'message',
        'author_name',
        'author_email',
        'author_login',
        'committed_at',
        'url',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'committed_at' => 'datetime',
        ];
    }

    public function repository(): BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }
}
