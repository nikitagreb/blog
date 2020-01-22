<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnTextInTablePost extends Migration
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
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn('text');
        });

        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->longText('text')
                ->charset('utf8mb4')
                ->collation('utf8mb4_unicode_ci')
                ->nullable(false)
                ->comment('Текст новости');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn('text');
        });
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->text('text')
                ->charset('utf8mb4')
                ->collation('utf8mb4_unicode_ci')
                ->nullable(false)
                ->comment('Текст новости');
        });
    }
}
