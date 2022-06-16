<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Posts/Index', []);
    }

    public function create(): Response
    {
        return Inertia::render('Posts/Create', []);
    }

    public function store()
    {
        Request::validate([
            'title' => ['required', 'min:8'],
            'content' => ['required'],
        ]);
    }
}
