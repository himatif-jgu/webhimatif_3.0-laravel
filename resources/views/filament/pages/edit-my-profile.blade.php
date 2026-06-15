<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap gap-3">
            <x-filament::button type="submit" icon="heroicon-o-check">
                Save Profile
            </x-filament::button>

            <x-filament::button tag="a" href="{{ \App\Filament\Pages\MyProfile::getUrl() }}" color="gray" icon="heroicon-o-x-mark">
                Cancel
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
