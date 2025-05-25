<section class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Daftar untuk {{ $program->name }}</h2>
        <p>Lengkapi formulir di bawah untuk mendaftar ke program renang kami.</p>
    </div>
    <div class="container">
        <form wire:submit.prevent="submit" class="needs-validation" novalidate data-aos="fade-up" data-aos-delay="100">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="parentName" class="form-label">Nama Orang Tua</label>
                    <input type="text" wire:model="parentName" class="form-control" id="parentName" required>
                    @error('parentName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="parentEmail" class="form-label">Email Orang Tua</label>
                    <input type="email" wire:model="parentEmail" class="form-control" id="parentEmail" required>
                    @error('parentEmail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="parentPhone" class="form-label">Telepon Orang Tua</label>
                    <input type="tel" wire:model="parentPhone" class="form-control" id="parentPhone" required>
                    @error('parentPhone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="studentName" class="form-label">Nama Siswa</label>
                    <input type="text" wire:model="studentName" class="form-control" id="studentName" required>
                    @error('studentName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="student_age" class="form-label">Usia Siswa</label>
                    <input type="number" wire:model="studentAge" class="form-control" id="studentAge" required>
                    @error('student_age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="student_gender" class="form-label">Jenis Kelamin Siswa</label>
                    <select wire:model="studentGender" class="form-select" id="studentGender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                    @error('student_gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="student_photo" class="form-label">Foto Siswa</label>
                    <input type="file" wire:model="studentPhoto" class="form-control" id="studentPhoto">
                    @error('student_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="medical_notes" class="form-label">Catatan Medis</label>
                    <textarea wire:model="medicalNotes" class="form-control" id="medicalNotes"></textarea>
                    @error('medical_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                </div>
            </div>
        </form>
    </div>
</section>