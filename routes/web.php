<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', HomeController::class)->name('home');

// Public subpages (Inertia + React). Presentation only — see PageController.
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/layanan', [PageController::class, 'services'])->name('services');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{blog}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');

// Auth (session-based, public site). Separate from Filament /admin guard.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// SEO: robots + sitemap (dynamic so the domain follows APP_URL / the request host).
Route::get('/robots.txt', function () {
    $body = implode("\n", [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        'Disallow: /login',
        'Disallow: /register',
        'Disallow: /logout',
        'Disallow: /livewire',
        '',
        'Sitemap: ' . url('/sitemap.xml'),
    ]) . "\n";

    return response($body, 200, ['Content-Type' => 'text/plain']);
});

Route::get('/sitemap.xml', function () {
    $pages = [
        ['loc' => url('/'),        'changefreq' => 'weekly',  'priority' => '1.0'],
        ['loc' => url('/tentang'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/layanan'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => url('/daftar'),  'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => url('/blog'),    'changefreq' => 'weekly',  'priority' => '0.7'],
        ['loc' => url('/kontak'),  'changefreq' => 'yearly',  'priority' => '0.6'],
    ];

    $blogs = rescue(fn () => \App\Models\Blogs::latest('updated_at')->get(['id', 'updated_at']), collect());
    foreach ($blogs as $b) {
        $pages[] = [
            'loc'        => url('/blog/' . $b->id),
            'lastmod'    => optional($b->updated_at)->toAtomString(),
            'changefreq' => 'monthly',
            'priority'   => '0.6',
        ];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
        . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($pages as $p) {
        $xml .= '  <url><loc>' . e($p['loc']) . '</loc>';
        if (! empty($p['lastmod'])) {
            $xml .= '<lastmod>' . $p['lastmod'] . '</lastmod>';
        }
        $xml .= '<changefreq>' . $p['changefreq'] . '</changefreq>'
            . '<priority>' . $p['priority'] . '</priority></url>' . "\n";
    }
    $xml .= '</urlset>' . "\n";

    return response($xml, 200, ['Content-Type' => 'application/xml']);
});