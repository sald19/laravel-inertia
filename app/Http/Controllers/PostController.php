<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\CouponCodes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Posts/Create', []);
    }

    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $posts = $user->posts()->with('user')->latest()->get();
        $posts = PostResource::collection($posts);

        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }

    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    public function store(): RedirectResponse
    {
        $validated = Request::validate([
            'title' => ['required', 'min:8'],
            'content' => ['required'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->posts()->create($validated);

        CouponCodes::create([
            'code' => 'FURULLA',
            'start_at' => '2022-09-12T16:58:27.000000Z',
            'end_At' => null,
        ]);

        return Redirect::route('posts.index')->with('success', 'Post created.');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Posts/Edit', ['post' => $post]);
    }

    public function update(): RedirectResponse
    {
        return Redirect::route('posts.index')->with('success', 'Post Updated.');
    }
}
