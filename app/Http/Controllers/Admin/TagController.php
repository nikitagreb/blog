<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\Tags\{StoreRequest, UpdateRequest};

/**
 * Class TagController
 * @package App\Http\Controllers\Admin
 */
class TagController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $query = Tag::with(['posts'])->orderBy('updated_at', 'desc');

        // todo вынести этот код от сюда
        // @see https://appdividend.com/2018/05/03/how-to-create-filters-in-laravel/
        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }
        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        $tags = $query->paginate(20);
        $statusList = Tag::statusList();

        return view('admin.tags.index', compact('tags', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.tags.create', [
            'statusList' => Tag::statusList(),
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $tag = Tag::create([
            'name' => $request['name'],
            'status' => $request['status'],
            'slug' => Str::slug($request['name'], '-'),
        ]);

        return redirect()->route('admin.tags.show', compact('tag'));
    }

    /**
     * @param Tag $tag
     * @return Response
     */
    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * @param Tag $tag
     * @return Factory|View
     */
    public function edit(Tag $tag)
    {
        $statusList = Tag::statusList();

        return view('admin.tags.edit', compact('tag', 'statusList'));
    }

    /**
     * @param UpdateRequest $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        $tag->update($request->only(['name', 'status']));

        return redirect()->route('admin.tags.show', compact('tag'));

    }

    /**
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->status = $tag->isActive() ? Tag::STATUS_NOT_ACTIVE : Tag::STATUS_ACTIVE;
        $tag->save();

        return redirect()->route('admin.tags.index' );
    }
}
