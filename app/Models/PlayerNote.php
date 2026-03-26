<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['player_id', 'user_id', 'note'])]
class PlayerNote extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (PlayerNote $note): void {
            $note->created_at = $note->freshTimestamp();
        });
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
