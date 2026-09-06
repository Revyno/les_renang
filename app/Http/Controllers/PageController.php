<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Blogs;
use App\Models\Categories;
use App\Models\FAQ;
use App\Models\Service;
use App\Models\Teams;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'services' => Service::where('status', 1)->orderBy('title')->get(['id', 'title', 'short_desc', 'icon_class']),
            'faqs' => FAQ::where('status', 1)->limit(6)->get(['id', 'question', 'answer']),
        ]);
    }

    public function services(): Response
    {
        return Inertia::render('Services', [
            'services' => Service::where('status', 1)->orderBy('title')->get(['id', 'title', 'short_desc', 'icon_class']),
        ]);
    }

    public function serviceShow(int $id): Response
    {
        return Inertia::render('ServiceDetail', [
            'service' => Service::where('status', 1)->findOrFail($id, ['id', 'title', 'short_desc', 'description']),
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('About', [
            'aboutus' => AboutUs::first(['title', 'description', 'img']),
            'teams' => Teams::where('status', 1)->get(['id', 'imgUrl', 'name', 'position', 'fblink', 'instalink', 'twitterlink']),
        ]);
    }

    public function team(): Response
    {
        return Inertia::render('Team', [
            'teams' => Teams::where('status', 1)->get(['id', 'imgUrl', 'name', 'position', 'fblink', 'instalink', 'twitterlink']),
        ]);
    }

    public function blogs(Request $request): Response
    {
        $categorySlug = $request->query('categorySlug');

        $query = Blogs::query()->latest();

        if ($categorySlug) {
            $category = Categories::where('slug', $categorySlug)->first();
            $query->where('categories_id', $category?->id ?? 0);
        }

        return Inertia::render('Blogs', [
            'blogs' => $query
                ->paginate(6, ['id', 'title', 'short_desc', 'imgUrl', 'categories_id', 'created_at'])
                ->withQueryString(),
            'categories' => Categories::get(['id', 'name', 'slug']),
            'categorySlug' => $categorySlug,
        ]);
    }

    public function blogShow(int $id): Response
    {
        $blog = Blogs::findOrFail($id, ['id', 'title', 'description', 'imgUrl', 'categories_id', 'created_at']);

        return Inertia::render('BlogDetail', [
            'blog' => $blog,
            'category' => Categories::find($blog->categories_id, ['id', 'name']),
            'recent' => Blogs::latest()->where('id', '!=', $blog->id)->limit(4)
                ->get(['id', 'title', 'imgUrl', 'created_at']),
        ]);
    }

    public function faq(): Response
    {
        return Inertia::render('Faq', [
            'faqs' => FAQ::where('status', 1)->get(['id', 'question', 'answer']),
        ]);
    }

    public function contact(): Response
    {
        return Inertia::render('Contact');
    }
}
