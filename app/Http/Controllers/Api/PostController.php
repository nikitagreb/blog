<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function getList($cnt, $categoryAlias = null)
    {
        header('Access-Control-Allow-Origin: ' . env('APP_URL_FRONT'));

        $builder = Post::where('status', '=', Post::STATUS_PUBLISHED)
            ->with(['tags'])
            ->orderBy('id', 'desc');

        return $builder->simplePaginate($cnt);
    }

    public function view($id)
    {
        header('Access-Control-Allow-Origin: ' . env('APP_URL_FRONT'));

        $post = Post::with(['tags'])->findOrFail($id);

        return array_merge(['text' => $post->text], $post->toArray());
    }
}
