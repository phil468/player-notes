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

    public function create(array $data): PlayerNote;
}
