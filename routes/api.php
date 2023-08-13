<?php

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/{post:slug}', function (Post $post) {
    if (!$post->active || $post->published_at > Carbon::now()) {
        throw new NotFoundHttpException();
    }
    $arr = [
        'message' => 'Chi tiết tin ' . $post->title,
        'data' => $post
    ];
    return response()->json($arr, 200);
});

Route::get('/category/{category:slug}', function (Category $category) {
    if (!$category) {
        throw new NotFoundHttpException();
    }
    $posts =
        Post::query()
        ->join('category_post', 'posts.id', '=', 'category_post.post_id')
        ->where('active', 1)
        ->where('category_post.category_id', $category->id)
        ->whereDate('published_at', '<=', Carbon::now())
        ->orderBy('published_at', 'desc')
        ->get();
    $arr = [
        'message' => 'Tin theo loại: ' . $category->title,
        'data' => $posts
    ];

    return response()->json($arr, 200);
});
