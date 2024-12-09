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
        Schema::create('restrictions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tree4_code'); //المبلغ
            $table->integer('Dain')->nullable(); //دائن // دافع//مستلم
            $table->integer('Madin')->nullable(); //مدين // مستلم//مسلم
            $table->date('date'); //التاريخ
            $table->longText('Statement')->nullable(); //البيان
            $table->unsignedBigInteger('op_id');
            $table->foreign('op_id')->references('id')->on('operations')->onDelete('cascade');
            $table->bigInteger('Constraint_number'); //رقم القيد
            $table->bigInteger('invoice_number')->nullable();
            $table->bigInteger('sales_car_number')->nullable();
            $table->bigInteger('transport_number')->nullable();
            $table->string('type'); //نوع القيد
             $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); //المستخدم
             $table->softDeletes();
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
        Schema::dropIfExists('restrictions');
    }
};
