<section id="blog" class="blog section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Blog Terbaru</h2>
        <p>Baca artikel terbaru tentang tips renang dan berita dari Tirta Nirwana.</p>
    </div>
    <div class="container">
        <div class="row gy-4 posts-list">
            @foreach($posts as $post)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                    <article class="d-flex flex-column">
                        <div class="post-img">
                            <img src="{{ asset($post['image']) }}" alt="" class="img-fluid">
                        </div>
                        <h2 class="title">
                            <a href="{{ route('blog') }}">{{ $post['title'] }}</a>
                        </h2>
                        <div class="meta-top">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-person"></i> {{ $post['author'] }}</li>
                                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->format('M d, Y') }}</time></li>
                            </ul>
                        </div>
                        <div class="content">
                            <p>{{ $post['excerpt'] }}</p>
                        </div>
                        <div class="read-more mt-auto align-self-end">
                            <a href="{{ route('blog') }}">Baca Selengkapnya</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>