<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string('code', 20)->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('user2_id');
                $table->string('type', 20)->nullable();
                $table->decimal('amount', 20, 2)->default(0);
                $table->string('memo', 191)->nullable();
                $table->boolean('confirmed')->default(1);
                $table->longText('data')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
