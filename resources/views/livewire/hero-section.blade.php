<section id="hero" class="hero section dark-background">
    <img src="{{ asset($hero['image']) }}" alt="" data-aos="fade-in">
    <div class="container d-flex flex-column align-items-left">
        <h2 data-aos="fade-up" data-aos-delay="100">{{ $hero['title'] }}</h2>
        <p data-aos="fade-up" data-aos-delay="200">{{ $hero['description'] }}</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('register') }}" class="btn-get-started">Daftar Sekarang</a>
            <a href="#program-les" class="btn-learn-more">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</section>