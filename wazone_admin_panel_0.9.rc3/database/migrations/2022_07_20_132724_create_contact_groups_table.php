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
        if (!Schema::hasTable('contact_groups')) {
            Schema::create('contact_groups', function (Blueprint $table) {
                $table->id();
                $table->string('sender', 50);
                $table->string('groupId', 50);
                $table->string('subject', 191);
                $table->string('subjectOwner', 50)->nullable();
                $table->string('subjectTime', 50)->nullable();
                $table->integer('size')->nullable();
                $table->string('creation', 50)->nullable();
                $table->string('owner', 50)->nullable();
                $table->string('desc', 191)->nullable();
                $table->string('descId', 50)->nullable();
                $table->boolean('restrict')->default(0);
                $table->boolean('announce')->default(0);
                $table->longText('participants')->nullable();
                $table->string('ephemeralDuration', 50)->nullable();
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
        Schema::dropIfExists('contact_groups');
    }
};
