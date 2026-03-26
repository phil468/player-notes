<div>
    <h3 class="text-lg font-semibold mb-4">Player Notes</h3>

    @if ($canCreate)
        <form wire:submit="save" class="mb-6">
            <div class="mb-2">
                <textarea
                    wire:model="note"
                    rows="3"
                    maxlength="500"
                    placeholder="Write a note..."
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>

                @error('note')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
            >
                Add Note
            </button>
        </form>
    @endif

    <div class="space-y-4">
        @forelse ($notes as $note)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-medium text-gray-700">
                        {{ $note->author?->name ?? 'Unknown' }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $note->created_at->format('M d, Y H:i') }}
                    </span>
                </div>
                <p class="text-gray-600">{{ $note->note }}</p>
            </div>
        @empty
            <p class="text-gray-400 italic">No notes yet.</p>
        @endforelse
    </div>
</div>
