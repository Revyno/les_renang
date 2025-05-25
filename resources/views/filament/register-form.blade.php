<div>
    <form wire:submit.prevent="register" class="space-y-8">
        <!-- Tambahkan field register di sini -->
        
        <x-filament::button type="submit" class="w-full">
            {{ __('Daftar') }}
        </x-filament::button>
    </form>
</div>