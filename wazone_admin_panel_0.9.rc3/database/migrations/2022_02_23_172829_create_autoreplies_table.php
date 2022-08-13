<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('autoreplies')) {
            Schema::create('autoreplies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('sender', 50)->nullable();
                $table->string('keyword', 191)->nullable();
                $table->tinyInteger('match_percent')->default(100);
                $table->mediumText('response')->nullable();
                $table->longText('data')->nullable();
                $table->string('mediafile', 191)->nullable();
                $table->text('mediaurl')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autoreplies');
    }
};
