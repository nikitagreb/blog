<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ImageHelper;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $name Заголовок
 * @property string $alt Псевдоним для ссылки
 * @property string $title Заголовок страницы
 * @property int $image_table_id
 * @property string $image_table_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereImageTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereImageTableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use ImageHelper;

    /** @var string */
    protected $table = 'images';

    /** @var array  */
    protected $fillable = [
        'name', 'title', 'alt', 'image_table_id', 'image_table_type',
    ];

    /** @var array  */
    protected const MODEL_LIST = [
        Post::class => 'posts',
    ];

    /** @var string */
    protected const DIR = 'images';

    /** @var string */
    protected const COLUMN_TYPE = 'image_table_type';

    /** @var string */
    protected const COLUMN_ID = 'image_table_id';
}
