<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function getList($cnt)
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

        $post = Post::where('status', '=', Post::STATUS_PUBLISHED)->with(['tags'])->findOrFail($id);

        return array_merge(['text' => $post->text], $post->toArray());
    }

    public function getNextPost($id)
    {
        header('Access-Control-Allow-Origin: ' . env('APP_URL_FRONT'));

        $post = Post::where('id', '>', $id)
            ->where('status', '=', Post::STATUS_PUBLISHED)
            ->first();

        if ($post === null) {
            throw (new ModelNotFoundException)->setModel(
                Post::class, $id
            );
        }

        return array_merge(['text' => $post->text], $post->toArray());
    }
}
