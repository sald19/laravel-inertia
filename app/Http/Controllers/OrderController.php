<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Orders/Create', ['test' => 'primera furulla']);
    }

    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'title' => 'required|min:8',
            'active' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) {
                    if (true) {
                        $fail(__('Subscribe to a Plan in order to be able to customize shippings.'));
                    }
                },
            ],
        ]);

        Inertia::share('paymentId', 'Gordoza');

        return redirect()->back()->with('paymentId', 'Gordoza 2');
    }
}
