<section id="gallery" class="gallery section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Galeri</h2>
        <p>Lihat momen-momen seru dari kelas renang kami.</p>
    </div>
    <div class="container-fluid">
        <div class="row g-0">
            @foreach($galleries as $gallery)
                <div class="col-lg-3 col-md-4">
                    <div class="gallery-title" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                        <a href="{{ asset($gallery['image']) }}" class="glightbox" data-gallery="images-gallery">
                            <img src="{{ asset($gallery['image']) }}" class="img-fluid" alt="{{ $gallery['caption'] }}">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>