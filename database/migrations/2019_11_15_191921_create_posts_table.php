<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /** @var string */
    private const TABLE_NAME = 'posts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::TABLE_NAME, function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');

            $table->string('h1', 100)->comment('Заголовок');
            $table->string('title', 100)->comment('Заголовок страницы');
            $table->string('description', 200)->comment('Описание');
            $table->string('keywords', 200)->comment('Ключевые слова');
            $table->text('text')
                ->charset('utf8mb4')
                ->collation('utf8mb4_unicode_ci')
                ->comment('Текст новости');
            $table->enum('status', ['published', 'unpublished'])
                ->default('unpublished')
                ->comment('Статус');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::TABLE_NAME);
    }
}
