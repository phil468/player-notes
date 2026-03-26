<?php

namespace App\Livewire;

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PlayerNotes extends Component
{
    #[Locked]
    public int $playerId;

    #[Validate('required|string|max:500')]
    public string $note = '';

    public function mount(int $playerId): void
    {
        $this->playerId = $playerId;
    }

    public function save(PlayerNoteRepositoryInterface $repository): void
    {
        $this->authorize('create player note');

        $this->validate();

        $repository->create([
            'player_id' => $this->playerId,
            'user_id' => Auth::id(),
            'note' => $this->note,
        ]);

        $this->reset('note');
        // $this->resetValidation();
    }

    public function render(PlayerNoteRepositoryInterface $repository): View
    {
        return view('livewire.player-notes', [
            'notes' => $repository->getByPlayerId($this->playerId),
            'canCreate' => Auth::user()?->can('create player note') ?? false,
        ]);
    }
}
