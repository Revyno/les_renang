@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card stat-card bg-info">
            <i class="fas fa-user-plus"></i>
            <div class="stat-count">{{ $registrationCount }}</div>
            <div class="stat-label">Total Pendaftaran</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <i class="fas fa-calendar-day"></i>
            <div class="stat-count">{{ $registrationToday }}</div>
            <div class="stat-label">Pendaftaran Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <i class="fas fa-book"></i>
            <div class="stat-count">{{ $programCount }}</div>
            <div class="stat-label">Total Program</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-danger text-white">
            <i class="fas fa-user-tie"></i>
            <div class="stat-count">{{ $instructorCount }}</div>
            <div class="stat-label">Total Instruktur</div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Statistik Pendaftaran ({{ date('Y') }})</span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartOptionsDropdown">
                        <li><a class="dropdown-item" href="#">Tampilkan Data Tahunan</a></li>
                        <li><a class="dropdown-item" href="#">Unduh Laporan</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="registrationChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Pendaftaran Terbaru
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($latestRegistrations as $registration)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $registration->nama }}</h6>
                                <small class="text-muted">{{ $registration->program }} - {{ $registration->created_at->format('d M Y') }}</small>
                            </div>
                            <a href="{{ route('admin.registrations.show', $registration) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Status Pendaftaran
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Program Terpopuler
            </div>
            <div class="card-body">
                <canvas id="programChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Chart untuk statistik pendaftaran bulanan
    const ctx = document.getElementById('registrationChart').getContext('2d');
    const registrationChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendaftaran',
                data: @json($chartData),
                backgroundColor: 'rgba(0, 153, 204, 0.1)',
                borderColor: 'rgba(0, 153, 204, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(0, 153, 204, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Chart untuk status pendaftaran
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Contacted', 'Enrolled', 'Cancelled'],
            datasets: [{
                data: [12, 8, 15, 3],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Chart untuk program terpopuler
    const programCtx = document.getElementById('programChart').getContext('2d');
    const programChart = new Chart(programCtx, {
        type: 'bar',
        data: {
            labels: ['Les Private', 'Les Semi Private', 'Les Group'],
            datasets: [{
                label: 'Pendaftaran',
                data: [18, 12, 8],
                backgroundColor: [
                    'rgba(0, 153, 204, 0.8)',
                    'rgba(102, 16, 242, 0.8)',
                    'rgba(111, 66, 193, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection