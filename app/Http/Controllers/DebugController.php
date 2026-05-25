<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class DebugController extends Controller
{
    public function mail()
    {
        Mail::raw('Test Email', function ($message) {
            $message->to('exryze@gmail.com')
                    ->subject('Mailtrap Test');
        });
    
        return "Mail sent!";
    }

    
    public function index()
    {
        return view('exryze.debug.page.index');
    }
}
