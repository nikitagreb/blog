<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $h1 Заголовок
 * @property string $title Заголовок страницы
 * @property string $description Описание
 * @property string $keywords Ключевые слова
 * @property string $text Текст новости
 * @property string $status Статус
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property string $slug Псевдоним для ссылки
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 */
class Post extends Model
{
    /** @var string */
    public const STATUS_UNPUBLISHED = 'unpublished';
    /** @var string */
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'h1', 'title', 'description', 'keywords', 'text', 'status', 'slug',
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getStatusName(): string
    {
        return self::statusList()[$this->status];
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public static function statusList(): array
    {
        return [
            static::STATUS_PUBLISHED => 'Опубликовано',
            static::STATUS_UNPUBLISHED => 'Не опубликовано',
        ];
    }
}
