<?php

namespace App\Http\Middleware;

use App\Support\Content;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template loaded on the first page visit.
     */
    protected $rootView = 'app';

    /**
     * Props shared with every Inertia response.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user()
                    ? $request->user()->only('id', 'name', 'email')
                    : null,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'cloudinary' => [
                'cloudName' => config('services.cloudinary.cloud_name'),
            ],
            // Site-wide contact info for Navbar/Footer/WhatsApp. Lazy: one query,
            // only resolved on full-page loads / when requested.
            'site' => fn () => Content::site(),
        ]);
    }
}
