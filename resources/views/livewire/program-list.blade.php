<section id="program-les" class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Program Les Renang</h2>
        <p>Pilih program renang yang sesuai dengan kebutuhan Anda.</p>
    </div>
    <div class="container">
        <div class="row">
            @foreach($programs as $index => $program)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                    <div class="card h-100">
                        @if($program->thumbnail)
                            <img src="{{ asset($program->thumbnail) }}" class="card-img-top" alt="{{ $program->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $program->name }}</h5>
                            <p class="card-text">Kelas: {{ $program->class->title }}</p>
                            <p class="card-text">Rentang Usia: {{ $program->age_range }}</p>
                            <p class="card-text">Jadwal: {{ $program->day }}, {{ $program->start_time }} - {{ $program->end_time }}</p>
                            <p class="card-text">Kapasitas: {{ $program->capacity }} slot</p>
                            <p class="card-text">Deskripsi: {{ $program->description }}</p>
                            <a wire:navigate href="{{ route('register.program', $program->id) }}" class="btn btn-primary mb-2">Daftar Sekarang</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}?text=Saya tertarik dengan {{ urlencode($program->name) }}" target="_blank" class="btn btn-success">Tanya via WhatsApp</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>