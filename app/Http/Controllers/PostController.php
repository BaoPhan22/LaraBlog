<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function home(): View
    {
        $latestPost = Post::where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $popularPosts = Post::leftJoin('upvote_downvotes', 'posts.id', '=', 'upvote_downvotes.post_id')
            ->select('posts.*', DB::raw('COUNT(upvote_downvotes.id) as upvote_count'))
            ->where(function ($query) {
                $query->whereNull('upvote_downvotes.is_upvote')->orWhere('upvote_downvotes.is_upvote', 1);
            })
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('upvote_count', 'desc')
            ->groupBy('posts.id')
            ->limit(3)
            ->get();

        $user = auth()->user();
        if ($user) {
            $leftJoin = "(SELECT cp.category_id, cp.post_id FROM upvote_downvotes JOIN category_post cp ON upvote_downvotes.post_id = cp.post_id WHERE upvote_downvotes.is_upvote = 1 and upvote_downvotes.user_id =?)as t";
            $recommendedPosts = Post::query()->leftJoin('category_post as cp', 'posts.id', '=', 'cp.post_id')->leftJoin(DB::raw($leftJoin), function ($join) {
                $join->on('t.category_id', '=', 'cp.category_id')->on('t.post_id', '<>', 'cp.post_id');
            })
                ->select('posts.*')
                ->where('posts.id', '<>', DB::raw('t.post_id'))
                ->setBindings([$user->id])
                ->where('active', 1)
                ->whereDate('published_at', '<', Carbon::now())
                ->limit(3)->get();
        } else {
            $recommendedPosts = Post::leftJoin('upvote_downvotes', 'posts.id', '=', 'upvote_downvotes.post_id')
                ->select('posts.*', DB::raw('COUNT(upvote_downvotes.id) as upvote_count'))
                ->where(function ($query) {
                    $query->whereNull('upvote_downvotes.is_upvote')->orWhere('upvote_downvotes.is_upvote', 1);
                })
                ->where('active', 1)
                ->whereDate('published_at', '<', Carbon::now())
                ->orderBy('upvote_count', 'desc')
                ->groupBy('posts.id')
                ->limit(3)
                ->get();
        }

        $categories = Category::query()
        ->select('categories.*')
        ->selectRaw('MAX(posts.published_at) as max_date')
        ->join('category_post','categories.id','=','category_post.category_id')
        ->leftJoin('posts','posts.id','=','category_post.post_id')
        ->orderByDesc('max_date')
        ->groupBy('categories.id')
        ->limit(5)
        ->get();

        return view('home', compact('latestPost', 'popularPosts', 'recommendedPosts','categories'));
    }

    public function show(Post $post)
    {
        if (!$post->active || $post->published_at > Carbon::now()) {
            throw new NotFoundHttpException();
        }

        return view('post.show', compact('post'));
    }
}
