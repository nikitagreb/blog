<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\DeleteRequest;
use App\Http\Requests\Image\UpdateAltRequest;
use App\Http\Requests\Image\UploadRequest;
use App\Models\ImageAvatar;
use App\Models\Post;

class ImageController extends Controller
{
    public function uploadMain(UploadRequest $request)
    {
        $modelClass = $request['modelType'];
        $post = $modelClass::findOrFail($request['modelId']);

        $oldImages = ImageAvatar::where('avatar_table_id', '=', $request['modelId'])
            ->where('avatar_table_type', '=', $request['modelType'])
            ->get();

        foreach ($oldImages as $image) {
            $image->delete();
        }


        $image = ImageAvatar::createModel($post, $request->file('image'));

        return [
            'imageId' => $image->id,
            'imageUrl' => $image->getImage(),
        ];
    }

    public function delete(DeleteRequest $request)
    {
        $image = ImageAvatar::findOrFail($request['imageId']);

        return [
            'success' => $image->delete(),
        ];
    }

    public function updateAlt(UpdateAltRequest $request)
    {
        $image = ImageAvatar::findOrFail($request['imageId']);
        $image->alt = $request['imageAlt'];
        $image->title = $request['imageAlt'];

        return [
            'success' => $image->save(),
        ];
    }
}
