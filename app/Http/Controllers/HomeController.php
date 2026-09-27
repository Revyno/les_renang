<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Public home page. All content is pulled (via App\Support\Content) from the
 * same Eloquent models the Filament admin manages, so anything edited in the
 * admin appears here. Empty tables render tasteful fallbacks in the React
 * components rather than blank sections.
 */
class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Home', [
            'meta' => [
                'title' => 'Beranda',
                'description' => 'Tirta Nirwana | sekolah renang di Surabaya untuk segala usia. Pelatih bersertifikat, kolam aman, dan jadwal fleksibel.',
            ],
            'hero' => Content::hero(),
            'about' => Content::about(),
            'stats' => Content::stats(),
            'services' => Content::services(),
            'programs' => Content::programs(),
            'instructors' => Content::instructors(),
            'clients' => Content::clients(),
            'gallery' => Content::gallery(),
            'faqs' => Content::faqs(),
            'blogs' => Content::blogs(),
        ]);
    }
}