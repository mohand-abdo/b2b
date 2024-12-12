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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->integer('Dain')->nullable(); //دائن // دافع//من
            $table->integer('Madin')->nullable(); //مدين // مستلم//الي
            $table->bigInteger('price'); //المبلغ
            $table->date('date'); //التاريخ
            $table->longText('Statement')->nullable(); //البيان
            $table->bigInteger('Constraint_number'); //رقم القيد
            $table->bigInteger('invoice_number')->nullable();
            $table->bigInteger('sales_car_number')->nullable();
            $table->bigInteger('transport_number')->nullable();
            $table->foreignId('pluse_id')->nullable()->constrained()->cascadeOnDelete(); //
            $table->string('type'); //نوع القيد
             $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); //المستخدم
            $table->timestamps();
        });
    }
     
             // قيود يومية  =>1
             // سندات قبض =>2
             // سندات صرف  =>3
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
};
