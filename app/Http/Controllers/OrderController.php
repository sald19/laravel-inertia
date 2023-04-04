<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;

class OrderController extends Controller
{
    public function create()
    {
        return Inertia::render('Orders/Create', ['test' => 'primera furulla']);
    }

    public function store()
    {
        Inertia::share('paymentId', 'Gordoza');

        return redirect()->back()->with('paymentId', 'Gordoza 2');
    }
}
