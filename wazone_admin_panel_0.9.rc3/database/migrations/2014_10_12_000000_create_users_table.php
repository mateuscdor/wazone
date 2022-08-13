<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->unique();
                $table->string('email', 50)->unique();
                $table->string('phone', 50)->nullable();
                $table->string('password', 191);
                $table->string('role', 20)->default('user')->comment('admin, user');
                $table->string('lang', 20)->default('us');
                $table->string('theme', 20)->default('light-layout')->comment('light-layout, dark-layout');
                $table->integer('package_id')->default('2');
                $table->integer('trial_period')->default(30);
                $table->string('billing_interval', 20)->default('monthly')->comment('monthly');
                $table->unsignedBigInteger('current_sent')->default(0);
                $table->unsignedBigInteger('total_sent')->default(0);
                $table->rememberToken();
                $table->timestamp('billing_start')->useCurrent();
                $table->timestamp('billing_end')->nullable();
                $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
