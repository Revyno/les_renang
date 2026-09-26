<footer id="footer" class="footer dark-background">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6 footer-about">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                    <span class="sitename">Tirta Nirwana</span>
                </a>
                <p>{{ $contact['description'] }}</p>
                {{-- <div class="social-links d-flex mt-4">
                    @if($contact['twitter'])
                        <a href="{{ $contact['twitter'] }}"><i class="bi bi-twitter-x"></i></a>
                    @endif
                    @if($contact['facebook'])
                        <a href="{{ $contact['facebook'] }}"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if($contact['instagram'])
                        <a href="{{ $contact['instagram'] }}"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if($contact['linkedin'])
                        <a href="{{ $contact['linkedin'] }}"><i class="bi bi-linkedin"></i></a>
                    @endif
                </div> --}}
            </div>
            <div class="col-lg-2 col-md-6 footer-links">
                <h4>Link Berguna</h4>
                <ul>
                    <li><a wire:navigate href="{{ route('home') }}">Home</a></li>
                    <li><a wire:navigate href="{{ route('about') }}">About</a></li>
                    <li><a wire:navigate href="{{ route('gallery') }}">Gallery</a></li>
                    <li><a wire:navigate href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 footer-contact">
                <h4>Hubungi Kami</h4>
                <p>
                    {{ $contact['address'] }} <br>
                    <strong>Telepon:</strong> {{ $contact['phone'] }}<br>
                    <strong>Email:</strong> {{ $contact['email'] }}<br>
                </p>
            </div>
            <div class="col-lg-4 col-md-6 footer-newsletter">
                <h4>Newsletter Kami</h4>
                <p>Dapatkan pembaruan terbaru tentang les renang kami.</p>
                <form action="" method="post">
                    <input type="email" name="email" placeholder="Masukkan email Anda"><input type="submit" value="Berlangganan">
                </form>
            </div>
        </div>
    </div>
    <div class="container copyright text-center mt-4">
        <p>&copy; <span>Copyright</span> <strong class="px-1 sitename">Tirta Nirwana</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            Designed by <a href="#">Your Team</a>
        </div>
    </div>
</footer>