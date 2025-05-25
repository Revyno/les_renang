<x-filament::widget>
    <x-filament::card>
        {{-- Widget content --}}
      <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Student Dashboard</h2>
         <p>Welcome, {{ auth()->user()->name }}!</p>
        <p>This is your student dashboard. Here you can view your courses, grades, and other student-related information.</p>
    </x-filament::card>
</x-filament::widget>
