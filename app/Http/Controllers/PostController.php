<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
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
        $posts = PostResource::collection($user->posts()->latest()->get());

        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }

    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    public function store()
    {
        $validated = Request::validate([
            'title' => ['required', 'min:8'],
            'content' => ['required'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->posts()->create($validated);

        return Redirect::route('posts.index')->with('success', 'Post created.');
    }
}
