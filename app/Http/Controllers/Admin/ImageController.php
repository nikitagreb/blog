<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Image\{DeleteRequest, UpdateAltRequest, UploadRequest};
use App\Models\{Image, ImageAvatar};

class ImageController extends Controller
{
    /**
     * @param UploadRequest $request
     * @return array
     * @throws \Exception
     */
    public function uploadMain(UploadRequest $request)
    {
        $modelClass = $request['modelType'];
        $model = $modelClass::findOrFail($request['modelId']);

        $oldImages = ImageAvatar::where('avatar_table_id', '=', $request['modelId'])
            ->where('avatar_table_type', '=', $request['modelType'])
            ->get();
        foreach ($oldImages as $image) {
            $image->delete();
        }

        $image = ImageAvatar::createModel($model, $request->file('image'));

        return [
            'imageId' => $image->id,
            'imageUrl' => $image->getImage(),
        ];
    }

    /**
     * @param UploadRequest $request
     * @return array
     * @throws \Exception
     */
    public function uploadImage(UploadRequest $request)
    {
        $modelClass = $request['modelType'];
        $model = $modelClass::findOrFail($request['modelId']);
        $image = Image::createModel($model, $request->file('image'));

        return [
            'imageId' => $image->id,
            'imageUrl' => $image->getImage(),
        ];
    }

    /**
     * @param DeleteRequest $request
     * @return array
     * @throws \Exception
     */
    public function deleteMain(DeleteRequest $request)
    {
        $image = ImageAvatar::findOrFail($request['imageId']);

        return [
            'success' => $image->delete(),
        ];
    }

    /**
     * @param DeleteRequest $request
     * @return array
     * @throws \Exception
     */
    public function deleteImage(DeleteRequest $request)
    {
        $image = Image::findOrFail($request['imageId']);

        return [
            'success' => $image->delete(),
        ];
    }

    /**
     * @param UpdateAltRequest $request
     * @return array
     */
    public function updateMainAlt(UpdateAltRequest $request)
    {
        $image = ImageAvatar::findOrFail($request['imageId']);
        $image->alt = $request['imageAlt'];
        $image->title = $request['imageAlt'];

        return [
            'success' => $image->save(),
        ];
    }

    /**
     * @param UpdateAltRequest $request
     * @return array
     */
    public function updateImageAlt(UpdateAltRequest $request)
    {
        $image = Image::findOrFail($request['imageId']);
        $image->alt = $request['imageAlt'];
        $image->title = $request['imageAlt'];

        return [
            'success' => $image->save(),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getImages(Request $request)
    {
        $images = Image::whereImageTableId($request['modelId'])->whereImageTableType($request['modelType'])->get();
        $result = [];
        foreach ($images as $image) {
            $result[] = [
                'imageId' => $image->id,
                'imageUrl' => $image->getImage(),
            ];
        }

        return $result;
    }
}
