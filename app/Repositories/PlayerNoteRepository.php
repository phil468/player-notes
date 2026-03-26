<?php

namespace App\Repositories;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class PlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function __construct(
        private readonly PlayerNote $model,
    ) {}

    /**
     * @return Collection<int, PlayerNote>
     */
    public function getByPlayerId(int $playerId): Collection
    {
        return $this->model
            ->where('player_id', $playerId)
            ->with('author:id,name')
            ->latest('created_at')
            ->get();
    }

    public function create(array $data): PlayerNote
    {
        return $this->model->create($data);
    }
}
