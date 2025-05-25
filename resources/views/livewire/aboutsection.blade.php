<section id="about" class="about section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up" data-aos-delay="100">
                <h3>{{ $about['title'] }}</h3>
                <img src="{{ asset($about['image']) }}" class="img-fluid rounded-4 mb-4" alt="">
                <p>{{ $about['description'] }}</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="position-relative mt-4">
                <img src="{{ asset('assets/img/about-2.jpg') }}" class="img-fluid rounded-4 mb-4" alt="">
                <a href="{{ $about['video_url'] }}" class="glightbox pulsating-play-btn"></a>
            </div>
        </div>
    </div>
</section>