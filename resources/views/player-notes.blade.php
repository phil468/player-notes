<x-layouts.app :title="'Notes - ' . $player->name">
    <h1 class="text-2xl font-semibold mb-6">{{ $player->name }}</h1>

    <livewire:player-notes :player-id="$player->id" />
</x-layouts.app>
