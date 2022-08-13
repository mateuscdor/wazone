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
        if (!Schema::hasTable('packages')) {
            Schema::create('packages', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->nullable();
                $table->string('description', 191)->nullable();
                $table->decimal('rate_monthly', 20, 2)->default(0);
                $table->decimal('rate_yearly', 20, 2)->default(0);
                $table->integer('max_outbox')->unsigned()->default(0);
                $table->integer('max_device')->unsigned()->default(0);
                $table->integer('max_template')->unsigned()->default(0);
                $table->integer('max_phonebook')->unsigned()->default(0);
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
        Schema::dropIfExists('packages');
    }
};
