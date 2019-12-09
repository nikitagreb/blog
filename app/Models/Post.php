<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Markdown;

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
 * @property-read \App\Models\ImageAvatar $avatar
 * @property string $preview_text Текст превью
 * @property-read string $avatar_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePreviewText($value)
 */
class Post extends Model
{
    /** @var string */
    public const STATUS_UNPUBLISHED = 'unpublished';
    /** @var string */
    public const STATUS_PUBLISHED = 'published';

    /** @var array */
    protected $fillable = ['h1', 'title', 'description', 'keywords', 'text', 'status', 'slug', 'preview_text'];

    /** @var array */
    protected $hidden = ['status', 'updated_at', 'avatar', 'text'];

    /** @var array */
    protected $appends = ['avatar_url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getAvatarUrlAttribute()
    {
        return $this->attributes['avatarUrl'] = $this->avatar->getImage();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function avatar()
    {
        return $this->morphOne(ImageAvatar::class, 'avatar_table');
    }

    /**
     * @return string
     */
    public function getStatusName(): string
    {
        return self::statusList()[$this->status];
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    /**
     * @return \Illuminate\Support\HtmlString
     */
    public function getTextHtml()
    {
        return Markdown::parse($this->text);
    }

    /**
     * @return array
     */
    public static function statusList(): array
    {
        return [
            static::STATUS_PUBLISHED => 'Опубликовано',
            static::STATUS_UNPUBLISHED => 'Не опубликовано',
        ];
    }
}
