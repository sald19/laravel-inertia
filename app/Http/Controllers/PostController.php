<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function store(StorePostRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        logger(['$request->validated()' => $request->validated()]);

        $user->posts()->create($request->validated());

        return Redirect::route('posts.index')->with('success', 'Post created.');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Posts/Edit', ['post' => $post]);
    }

    public function update(Post $post, UpdatePostRequest $request): RedirectResponse
    {
        $post->update($request->validated());

        return Redirect::route('posts.index')->with('success', 'Post Updated.');
    }
}
