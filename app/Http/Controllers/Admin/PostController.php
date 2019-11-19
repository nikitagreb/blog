<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Arr;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\{StoreRequest, UpdateRequest};
use App\Models\{ImageAvatar, Post, Tag};

/**
 * Class PostController
 * @package App\Http\Controllers\Admin
 */
class PostController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $query = Post::with(['tags'])->orderBy('created_at', 'desc');

        // todo вынести этот код от сюда
        // @see https://appdividend.com/2018/05/03/how-to-create-filters-in-laravel/
        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }
        if (!empty($value = $request->get('h1'))) {
            $query->where('h1', 'like', '%' . $value . '%');
        }

        $posts = $query->paginate(20);
        $statusList = Post::statusList();

        return view('admin.posts.index', compact('posts', 'statusList'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.posts.create', [
            'statusList' => Post::statusList(),
            'tagList' => Arr::pluck(Tag::all(['id', 'name']),'name', 'id'),
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $post = Post::create([
            'h1' => $request['h1'],
            'title' => $request['title'],
            'description' => $request['description'],
            'keywords' => $request['keywords'],
            'text' => $request['text'],
            'status' => $request['status'],
            'slug' => Str::slug($request['h1'], '-'),
        ]);
        $post->tags()->sync($request['tags']);
        ImageAvatar::createModel($post, $request->file('avatar'));

        return redirect()->route('admin.posts.show', compact('post'));
    }

    /**
     * @param Post $post
     * @return Factory|View
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * @param Post $post
     * @return Factory|View
     */
    public function edit(Post $post)
    {
        $statusList = Post::statusList();
        $tagList = Arr::pluck(Tag::all(['id', 'name']),'name', 'id');

        return view('admin.posts.edit', compact('post', 'statusList', 'tagList'));
    }

    /**
     * @param UpdateRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Post $post)
    {
        $post->update($request->only(['h1', 'title', 'description', 'keywords', 'text', 'status']));
        $post->tags()->sync($request['tags']);

        return redirect()->route('admin.posts.show', compact('post'));
    }

    /**
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->status = $post->isPublished() ? Post::STATUS_UNPUBLISHED : Post::STATUS_PUBLISHED;
        $post->save();

        return redirect()->route('admin.posts.index' );
    }
}
