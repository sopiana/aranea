<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',300)->unique();
            $table->string('email',300)->unique();
            $table->string('password',100);
            $table->string('avatar',300);
            $table->string('first_name',300);
            $table->string('last_name',300);
            $table->string('company',300)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('mobile',100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('comment')->nullable();
            $table->integer('role_id',false,true)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('last_author',false,true)->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
