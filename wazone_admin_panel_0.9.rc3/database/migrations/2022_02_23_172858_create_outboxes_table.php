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
        if (!Schema::hasTable('outboxes')) {
            Schema::create('outboxes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('job_id', 50)->nullable();
                $table->string('sender', 50)->nullable();
                $table->string('receiver', 50)->nullable();
                $table->string('rec_name', 50)->nullable();
                $table->longText('data')->nullable();
                $table->string('mediafile', 191)->nullable();
                $table->text('mediaurl')->nullable();
                $table->mediumText('msgtext')->nullable();
                $table->timestamp('schedule')->nullable();
                $table->string('status', 20)->default('PENDING')->comment('PENDING, SENT, FAILED');
                $table->tinyInteger('try')->default(0);
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
        Schema::dropIfExists('outboxes');
    }
};
