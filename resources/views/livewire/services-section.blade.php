<!-- resources/views/livewire/services-section.blade.php -->
<section id="services" class="services section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Mengapa Memilih untuk Belajar Berenang di Tirta Nirwana</p>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
            @foreach($services as $service)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                        <div class="img">
                            <img src="{{ asset($service['image']) }}" class="img-fluid" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi {{ $service['icon'] }}"></i>
                            </div>
                            <h3>{{ $service['title'] }}</h3>
                            <p>{{ $service['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>