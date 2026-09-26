@extends('layouts.app')
@section('title', 'Register - Pt Tirta Nirwana')

@section('content')
    <section class="section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Daftar Akun</h2>
            <p>Buat akun untuk mendaftar ke program renang kami.</p>
        </div>
        <div class="container">
            <form wire:submit.prevent="register" class="needs-validation" novalidate data-aos="fade-up" data-aos-delay="100">
                <div class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" wire:model="name" class="form-control" id="name" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="email" class="form-control" id="email" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" wire:model="password" class="form-control" id="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" wire:model="password_confirmation" class="form-control" id="password_confirmation" required>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection