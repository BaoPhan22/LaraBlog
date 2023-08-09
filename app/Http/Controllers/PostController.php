<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function byCategory(Category $category): View
    {
        $posts = 
        Post::query()
            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('active', 1)
            ->where('category_post.category_id', $category->id)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('post.index', ['data' => $posts]);
    }
    
    public function index(): View
    {
        $posts = Post::query()
        ->where('active', 1)
        ->where('published_at', '<', Carbon::now())
        ->orderBy('published_at', 'desc')
        ->paginate(10);
        return view('home', ['data' => $posts]);
    }

    public function show(Post $post)
    {
        if (!$post->active || $post->published_at > Carbon::now()) {
            throw new NotFoundHttpException();
        }

        return view('post.show', compact('post'));
    }
}
