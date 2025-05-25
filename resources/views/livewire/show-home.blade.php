<!-- resources/views/livewire/show-home.blade.php -->
<div>
    @extends('layouts.app')
    @section('title', 'Home')
    @section('content')
        @livewire('hero-section')
        @livewire('about-section')
        @livewire('stats-section')
        @livewire('services-section')
        @livewire('clients-section')
        @livewire('testimonials-section')
        @livewire('team-section')
        @livewire('gallery-section')
        @livewire('contact-section')
        @livewire('faq-section')
    @endsection
</div>