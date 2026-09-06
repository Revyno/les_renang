<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $recipient = config('mail.contact_to', config('mail.from.address'));

        Mail::to($recipient)->send(new ContactEmail([
            'subject' => 'Pesan baru dari website Tirta Nirwana',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
        ]));

        return back()->with('success', 'Terima kasih! Pesan kamu sudah terkirim, kami akan segera membalas.');
    }
}
