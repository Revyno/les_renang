<section id="program-les" class="program-les section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Swimming Programs</h2>
        <p>CHOOSE THE RIGHT PROGRAM FOR YOU</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach($programs as $program)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="program-card">
                    <div class="program-header">
                        <h3>{{ $program->name }}</h3>
                        <h4>Rp {{ number_format($program->price, 0, ',', '.') }}<span>/session</span></h4>
                    </div>
                    <ul>
                        @foreach(explode("\n", $program->features) as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <div class="program-footer">
                        <a href="#contact" class="btn-get-started">Enroll Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>