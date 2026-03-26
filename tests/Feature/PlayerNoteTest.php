<?php

namespace Tests\Feature;

use App\Livewire\PlayerNotes;
use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PlayerNoteTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Player $player;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->player = Player::factory()->create();

        Permission::create(['name' => 'create player note']);
        $this->user->givePermissionTo('create player note');
    }

    public function test_authorized_user_can_create_a_note(): void
    {
        Livewire::actingAs($this->user)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->set('note', 'This is a test note')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('player_notes', [
            'player_id' => $this->player->id,
            'user_id' => $this->user->id,
            'note' => 'This is a test note',
        ]);
    }

    public function test_note_field_is_required(): void
    {
        Livewire::actingAs($this->user)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->set('note', '')
            ->call('save')
            ->assertHasErrors(['note' => 'required']);
    }

    public function test_note_cannot_exceed_500_characters(): void
    {
        Livewire::actingAs($this->user)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->set('note', str_repeat('a', 501))
            ->call('save')
            ->assertHasErrors(['note' => 'max']);
    }

    public function test_notes_are_listed_for_a_player(): void
    {
        PlayerNote::factory()->count(3)->create([
            'player_id' => $this->player->id,
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->assertViewHas('notes', fn ($notes) => $notes->count() === 3);
    }

    public function test_unauthorized_user_cannot_create_a_note(): void
    {
        $unauthorizedUser = User::factory()->create();

        Livewire::actingAs($unauthorizedUser)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->set('note', 'Should not be saved')
            ->call('save')
            ->assertForbidden();

        $this->assertDatabaseMissing('player_notes', [
            'note' => 'Should not be saved',
        ]);
    }

    public function test_form_is_hidden_for_users_without_permission(): void
    {
        $unauthorizedUser = User::factory()->create();

        Livewire::actingAs($unauthorizedUser)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->assertViewHas('canCreate', false);
    }

    public function test_note_field_resets_after_saving(): void
    {
        Livewire::actingAs($this->user)
            ->test(PlayerNotes::class, ['playerId' => $this->player->id])
            ->set('note', 'Reset after save')
            ->call('save')
            ->assertSet('note', '');
    }
}
