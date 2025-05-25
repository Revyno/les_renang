<x-filament::page>
    <x-filament::card>
        <form wire:submit.prevent="generateReport">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-filament::forms.field-wrapper
                    label="Tanggal Mulai"
                    required="true"
                >
                    <x-filament::input.wrapper>
                        <x-filament::input.date
                            wire:model.defer="startDate"
                            required
                        />
                    </x-filament::input.wrapper>
                </x-filament::forms.field-wrapper>

                <x-filament::forms.field-wrapper
                    label="Tanggal Akhir"
                    required="true"
                >
                    <x-filament::input.wrapper>
                        <x-filament::input.date
                            wire:model.defer="endDate"
                            required
                        />
                    </x-filament::input.wrapper>
                </x-filament::forms.field-wrapper>

                <div class="flex items-end">
                    <x-filament::button
                        type="submit"
                        icon="heroicon-s-filter"
                    >
                        Generate Laporan
                    </x-filament::button>
                </div>
            </div>
        </form>
    </x-filament::card>

    @if($reportData)
        <x-filament::card>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-filament::card>
                        <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                        <p class="text-2xl font-semibold">Rp {{ number_format($summary->sum('total_amount'), 0, ',', '.') }}</p>
                    </x-filament::card>

                    <x-filament::card>
                        <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
                        <p class="text-2xl font-semibold">{{ $summary->sum('total_transactions') }}</p>
                    </x-filament::card>

                    <x-filament::card>
                        <h3 class="text-sm font-medium text-gray-500">Rata-rata Pembayaran</h3>
                        <p class="text-2xl font-semibold">Rp {{ number_format($summary->avg('average_payment'), 0, ',', '.') }}</p>
                    </x-filament::card>

                    <x-filament::card>
                        <h3 class="text-sm font-medium text-gray-500">Periode</h3>
                        <p class="text-xl font-semibold">
                            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </p>
                    </x-filament::card>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-2">Distribusi Metode Pembayaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach($summary as $method)
                            <x-filament::card>
                                <h4 class="text-sm font-medium text-gray-500 capitalize">{{ $method->method }}</h4>
                                <p class="text-xl font-semibold">Rp {{ number_format($method->total_amount, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">{{ $method->method_count }} transaksi ({{ number_format($method->total_amount / $summary->sum('total_amount') * 100, 1) }}%)</p>
                            </x-filament::card>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-2">Detail Transaksi</h3>
                    <x-filament::table>
                        <x-slot name="header">
                            <x-filament::table.header>Invoice</x-filament::table.header>
                            <x-filament::table.header>Siswa</x-filament::table.header>
                            <x-filament::table.header>Kelas</x-filament::table.header>
                            <x-filament::table.header>Jumlah</x-filament::table.header>
                            <x-filament::table.header>Metode</x-filament::table.header>
                            <x-filament::table.header>Tanggal</x-filament::table.header>
                        </x-slot>

                        @foreach($reportData as $payment)
                            <x-filament::table.row>
                                <x-filament::table.cell>
                                    {{ $payment->invoice_number }}
                                </x-filament::table.cell>
                                <x-filament::table.cell>
                                    {{ $payment->user->name }}
                                </x-filament::table.cell>
                                <x-filament::table.cell>
                                    {{ $payment->registration->class->title }}
                                </x-filament::table.cell>
                                <x-filament::table.cell>
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </x-filament::table.cell>
                                <x-filament::table.cell>
                                    <span class="capitalize">{{ $payment->method }}</span>
                                </x-filament::table.cell>
                                <x-filament::table.cell>
                                    {{ $payment->paid_at->format('d M Y H:i') }}
                                </x-filament::table.cell>
                            </x-filament::table.row>
                        @endforeach
                    </x-filament::table>
                </div>
            </div>
        </x-filament::card>
    @endif
</x-filament::page>