@extends('layouts.app')
@section('title', 'Dashboard - Tirta Nirwana')

@section('content')
    <section class="section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Dashboard Pengguna</h2>
            <p>Lihat pendaftaran Anda dan kelola akun Anda.</p>
        </div>
        <div class="container">
            <h3>Selamat Datang, {{ auth()->user()->name }}</h3>
            <h4>Pendaftaran Anda</h4>
            @if($registrations->isEmpty())
                <p>Belum ada pendaftaran.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Nama Siswa</th>
                                <th>Status</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Pendaftaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->program->name }}</td>
                                    <td>{{ $registration->student_name }}</td>
                                    <td>{{ ucfirst($registration->status) }}</td>
                                    <td>{{ ucfirst($registration->payment_status) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
@endsection