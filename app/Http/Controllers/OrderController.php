<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Orders/Create', ['test' => 'primera furulla']);
    }

    public function store(): RedirectResponse
    {
        Inertia::share('paymentId', 'Gordoza');

        return redirect()->back()->with('paymentId', 'Gordoza 2');
    }
}
