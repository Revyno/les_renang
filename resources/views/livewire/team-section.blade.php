<!-- resources/views/livewire/team-section.blade.php -->
<section id="team" class="team section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Teacher</h2>
        <p>CHECK OUR TEACHER</p>
    </div>
    <div class="container">
        <div class="row gy-5">
            @foreach($instructors as $index => $instructor)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
                    <div class="member">
                        <div class="pic"><img src="{{ asset($instructor['image']) }}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>{{ $instructor['name'] }}</h4>
                            <span>{{ $instructor['title'] }}</span>
                            <div class="social">
                                <a href="{{ $instructor['social']['twitter'] }}"><i class="bi bi-twitter-x"></i></a>
                                <a href="{{ $instructor['social']['facebook'] }}"><i class="bi bi-facebook"></i></a>
                                <a href="{{ $instructor['social']['instagram'] }}"><i class="bi bi-instagram"></i></a>
                                <a href="{{ $instructor['social']['linkedin'] }}"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>