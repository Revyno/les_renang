<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Support\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Public subpages (Tentang, Layanan, Blog, FAQ, Kontak, Daftar). Presentation
 * only — reads the same admin-managed models via App\Support\Content and never
 * touches enrollment/payment business logic (PRD non-goal).
 */
class PageController extends Controller
{
    public function about(): Response
    {
        return Inertia::render('About', [
            'meta' => [
                'title' => 'Tentang Kami',
                'description' => 'Kenali Tirta Nirwana: visi, pelatih bersertifikat, dan pendekatan belajar berenang yang aman untuk segala usia.',
            ],
            'about' => Content::about(),
            'stats' => Content::stats(),
            'instructors' => Content::instructors(12),
        ]);
    }

    public function services(): Response
    {
        return Inertia::render('Services', [
            'meta' => [
                'title' => 'Layanan & Program',
                'description' => 'Pilihan layanan dan program renang Tirta Nirwana untuk anak hingga dewasa, dengan jadwal fleksibel.',
            ],
            'services' => Content::services(),
            'programs' => Content::programs(24),
        ]);
    }

    public function blog(): Response
    {
        $blogs = Blogs::query()->with('categories')->latest('id')->paginate(9)
            ->through(fn (Blogs $b) => Content::blogCard($b))
            ->withQueryString();

        return Inertia::render('Blog', [
            'meta' => [
                'title' => 'Blog',
                'description' => 'Tips latihan, wawasan, dan kabar terbaru seputar dunia renang dari tim Tirta Nirwana.',
            ],
            'blogs' => $blogs,
        ]);
    }

    public function blogShow(Blogs $blog): Response
    {
        $blog->loadMissing('categories');
        $desc = Str::limit(trim(strip_tags((string) ($blog->short_desc ?: $blog->description))), 150);

        return Inertia::render('BlogDetail', [
            'meta' => [
                'title' => $blog->title,
                'description' => $desc,
            ],
            'post' => Content::blogDetail($blog),
            'related' => Content::blogs(3),
        ]);
    }

    public function contact(): Response
    {
        return Inertia::render('Contact', [
            'meta' => [
                'title' => 'Kontak',
                'description' => 'Hubungi Tirta Nirwana untuk konsultasi program, jadwal, dan pendaftaran renang.',
            ],
        ]);
    }

    public function contactStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Table `contact` (name/email/phone/subject/message) is the existing
        // submissions store; write raw to avoid coupling to admin models.
        DB::table('contact')->insert($data + [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pesan Anda terkirim. Tim kami akan segera menghubungi Anda.');
    }

    public function daftar(): Response
    {
        return Inertia::render('RegisterProgram', [
            'meta' => [
                'title' => 'Daftar Program',
                'description' => 'Pilih program renang yang sesuai dan daftar dengan mudah bersama Tirta Nirwana.',
            ],
            'programs' => Content::programs(24),
        ]);
    }
}
