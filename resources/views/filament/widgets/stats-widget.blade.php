<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-2">Statistik</h2>
        <div>
            @if(isset($stats))
                <div class="space-y-2">
                    @foreach($stats as $key => $value)
                        <div class="flex justify-between">
                            <span>{{ ucfirst($key) }}:</span>
                            <span>{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center">Belum ada data statistik</div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>