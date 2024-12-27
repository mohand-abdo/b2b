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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('hajj_number'); // رقم الحاج
            $table->string('room_number'); // رقم الغرفة
            $table->string('bus_number'); // رقم الحافلة
            $table->decimal('amount', 10, 2); // المبلغ
            $table->decimal('tax', 5, 2); // الضريبة (%)
            $table->decimal('total_amount', 10, 2); // المبلغ شامل الضريبة
            $table->date('contract_date'); // تاريخ العقد
            $table->text('contract_terms')->nullable(); // شروط العقد
            $table->foreignId('tree4_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('tree4_code'); // تعديل النوع ليتطابق مع `tree4_code`
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete(); // حملة الحج والعمرة
            $table->unsignedBigInteger('bank_and_safe'); // الحساب
            // $table->unsignedBigInteger('user_id'); // المستخدم
            $table->string('attachment')->nullable(); // مرفق
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('contracts');
    }
};
