<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTree4sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree4s', function (Blueprint $table) {
            $table->id();
            $table->string('tree4_name');
            $table->unsignedBigInteger('tree4_code');
            $table->integer('tree3_code');
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('iden', 255)->nullable();
            $table->string('nationalty', 255)->nullable();
            $table->string('file', 255)->nullable();
            $table->integer('status')->default(1);
            $table->string('type', 255)->nullable();
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tree4s');
    }
}