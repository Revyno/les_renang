@extends('frontend.auth.layouts.layouts')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Pendaftaran Les Renang</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Informasi Orang Tua
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="parent_name" class="form-label">Nama Lengkap Orang Tua</label>
                                <input type="text" class="form-control" id="parent_name" name="parent_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="parent_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="parent_email" name="parent_email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="parent_phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="parent_phone" name="parent_phone" required>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Informasi Anak
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="child_name" class="form-label">Nama Lengkap Anak</label>
                                <input type="text" class="form-control" id="child_name" name="child_name" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="child_age" class="form-label">Usia</label>
                                <input type="number" class="form-control" id="child_age" name="child_age" min="3" max="18" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="child_gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="child_gender" name="child_gender" required>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="medical_notes" class="form-label">Catatan Kesehatan (Alergi, Kondisi Khusus, dll)</label>
                            <textarea class="form-control" id="medical_notes" name="medical_notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Pilihan Program
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="swim_level_id" class="form-label">Tingkatan Renang</label>
                            <select class="form-select" id="swim_level_id" name="swim_level_id" required>
                                <option value="">Pilih Tingkatan</option>
                                @foreach($swimLevels as $level)
                                    <option value="{{ $level->id }}" data-price="{{ $level->price }}">
                                        {{ $level->name }} - {{ number_format($level->price, 0, ',', '.') }} ({{ $level->sessions }} sesi)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="schedule_id" class="form-label">Jadwal</label>
                            <select class="form-select" id="schedule_id" name="schedule_id" required>
                                <option value="">Pilih Jadwal</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" 
                                        data-coach="{{ $schedule->coach->name }}"
                                        data-max="{{ $schedule->max_participants }}">
                                        {{ $schedule->day }}: {{ $schedule->start_time }} - {{ $schedule->end_time }} 
                                        (Pelatih: {{ $schedule->coach->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="summary" class="alert alert-info" style="display: none;">
                            <h5>Ringkasan Pendaftaran</h5>
                            <p><strong>Tingkatan:</strong> <span id="summary-level"></span></p>
                            <p><strong>Jadwal:</strong> <span id="summary-schedule"></span></p>
                            <p><strong>Pelatih:</strong> <span id="summary-coach"></span></p>
                            <p><strong>Biaya:</strong> Rp <span id="summary-price"></span></p>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swimLevelSelect = document.getElementById('swim_level_id');
        const scheduleSelect = document.getElementById('schedule_id');
        const summaryDiv = document.getElementById('summary');
        
        function updateSummary() {
            if (swimLevelSelect.value && scheduleSelect.value) {
                const selectedLevel = swimLevelSelect.options[swimLevelSelect.selectedIndex];
                const selectedSchedule = scheduleSelect.options[scheduleSelect.selectedIndex];
                
                document.getElementById('summary-level').textContent = selectedLevel.text;
                document.getElementById('summary-schedule').textContent = selectedSchedule.text.split('(')[0].trim();
                document.getElementById('summary-coach').textContent = selectedSchedule.dataset.coach;
                document.getElementById('summary-price').textContent = selectedLevel.dataset.price.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                
                summaryDiv.style.display = 'block';
            } else {
                summaryDiv.style.display = 'none';
            }
        }
        
        swimLevelSelect.addEventListener('change', updateSummary);
        scheduleSelect.addEventListener('change', updateSummary);
    });
</script>
@endsection