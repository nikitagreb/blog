<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShortTextInTablePost extends Migration
{
    private const TABLE = 'posts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->text('preview_text')
                ->charset('utf8mb4')
                ->collation('utf8mb4_unicode_ci')
                ->nullable()
                ->comment('Текст превью');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('preview_text');
        });
    }
}
