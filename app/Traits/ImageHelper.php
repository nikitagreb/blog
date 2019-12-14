<?php

namespace App\Traits;

use Image;
use Exception;
use File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

trait ImageHelper
{
    /**
     * @param $model
     * @param UploadedFile $file
     * @param string $altAttribute
     * @return static
     * @throws Exception
     */
    public static function createModel($model, UploadedFile $file, $altAttribute = 'h1'): self
    {
        $name = self::imageUpload($model, $file);

        return parent::create([
            'name' => $name,
            'alt' => $model->$altAttribute,
            'title' => $model->$altAttribute,
            static::COLUMN_ID => $model->id,
            static::COLUMN_TYPE => get_class($model),
        ]);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getImage(): string
    {
        return self::getOriginPath($this->{static::COLUMN_TYPE}, $this->{static::COLUMN_ID}, true) . '/' . $this->name;
    }

    /**
     * @return bool|null
     * @throws Exception
     */
    public function delete(): ?bool
    {
        $path = self::getOriginPath($this->{static::COLUMN_TYPE}, $this->{static::COLUMN_ID}, false);
        @unlink($path. '/' . $this->name);

        return parent::delete();
    }

    /**
     * @param $model
     * @param UploadedFile $file
     * @return string
     * @throws Exception
     */
    public static function imageUpload($model, UploadedFile $file): string
    {
        $path = self::getOriginPath(get_class($model), $model->id, false);

        $img = Image::make($file);
        $extension = $file->getClientOriginalExtension();
        $sourceWidth = $img->width();
        $sourceHeight = $img->height();

        $width = env('IMAGE_WIDTH');
        $height = env('IMAGE_HEIGHT');
        $quality = env('IMAGE_QUALITY');

        $name = Str::random(8) . '.' . $extension;
        if ($width < $sourceWidth || $height < $sourceHeight) {
            if ($sourceWidth > $sourceHeight) {
                $height = (($width * $sourceHeight) / $sourceWidth);
            } else {
                $width = (($height * $sourceWidth) / $sourceHeight);
            }
        } else {
            $width = $sourceWidth;
            $height = $sourceHeight;
        }

        $img->resize($width,$height)->save($path . DIRECTORY_SEPARATOR . $name, $quality);

        return $name;
    }

    /**
     * @param $model
     * @param $modelId
     * @param bool $byWeb
     * @return string
     * @throws Exception
     */
    protected static function getOriginPath($model, $modelId, bool $byWeb = true): string
    {
        $path = ($byWeb ? '/storage' : base_path() . '/storage/app/public') . '/original' . '/' . static::DIR;

        if (isset(static::MODEL_LIST[$model])) {
            $path .= '/' . static::MODEL_LIST[$model] . '/' . $modelId;
        } else {
            throw new Exception('Unknown entity ' . get_class($model));
        }

        if (!$byWeb && !File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;
    }
}
