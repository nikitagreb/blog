<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ImageHelper;

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
    use ImageHelper;

    /** @var string  */
    protected $table = 'images_avatar';

    /** @var array  */
    protected $fillable = [
        'name', 'title', 'alt', 'avatar_table_id', 'avatar_table_type',
    ];

    /** @var array  */
    protected const MODEL_LIST = [
        Post::class => 'posts',
    ];

    /** @var string */
    protected const DIR = 'avatars';

    /** @var string */
    protected const COLUMN_TYPE = 'avatar_table_type';

    /** @var string */
    protected const COLUMN_ID = 'avatar_table_id';
}
