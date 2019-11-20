<?php

namespace App\Models;

use Image;
use Exception;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * App\Models\ImageAvatar
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name Заголовок
 * @property string $alt Псевдоним для ссылки
 * @property string $title Заголовок страницы
 * @property int $avatar_table_id
 * @property string $avatar_table_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereAvatarTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereAvatarTableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageAvatar whereUpdatedAt($value)
 */
class ImageAvatar extends Model
{
    protected $table = 'images_avatar';

    protected $fillable = [
        'name', 'title', 'alt', 'avatar_table_id', 'avatar_table_type',
    ];

    /** @var array  */
    const MODEL_LIST = [
        Post::class => 'posts',
    ];

    /**
     * @param $model
     * @param UploadedFile $file
     * @param string $altAttribute
     * @return static
     */
    public static function createModel($model, UploadedFile $file, $altAttribute = 'h1'): self
    {
        $name = self::imageUpload($model, $file);

        return parent::create([
            'name' => $name,
            'alt' => $model->$altAttribute,
            'title' => $model->$altAttribute,
            'avatar_table_id' => $model->id,
            'avatar_table_type' => get_class($model),
        ]);
    }

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

    public function getImage(): string
    {
        return self::getOriginPath($this->avatar_table_type, $this->avatar_table_id, true) . '/' . $this->name;
    }

    public function delete(): ?bool
    {
        $path = self::getOriginPath($this->avatar_table_type, $this->avatar_table_id, false);
        @unlink($path. '/' . $this->name);

        return parent::delete();
    }

    /**
     * @param $model
     * @param $modelId
     * @param bool $byWeb
     * @return string
     * @throws Exception
     */
    private static function getOriginPath($model, $modelId, bool $byWeb = true): string
    {
        $path = ($byWeb ? '/storage' : base_path() . '/storage/app/public') . '/original';

        if (isset(self::MODEL_LIST[$model])) {
            $path .= '/' . self::MODEL_LIST[$model] . '/' . $modelId;
        } else {
            throw new Exception('Unknown entity ' . get_class($model));
        }

        if (!$byWeb && !File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;
    }
}
