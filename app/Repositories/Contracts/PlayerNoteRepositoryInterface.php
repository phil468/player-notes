<?php

namespace App\Repositories\Contracts;

use App\Models\PlayerNote;
use Illuminate\Database\Eloquent\Collection;

interface PlayerNoteRepositoryInterface
{
    /**
     * @return Collection<int, PlayerNote>
     */
    public function getByPlayerId(int $playerId): Collection;

    /**
     * @param array{player_id: int, user_id: int, note: string} $data
     */
    public function create(array $data): PlayerNote;
}
