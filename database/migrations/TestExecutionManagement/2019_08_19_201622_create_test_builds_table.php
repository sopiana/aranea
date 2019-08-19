<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestBuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_builds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('test_case_id', false, true);
            $table->string('name',250);
            $table->text('notes')->nullable();
            $table->integer('author_id',false,true);
            $table->date('release_date');
            $table->date('closed_date');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('test_builds');
        Schema::enableForeignKeyConstraints();
    }
}
