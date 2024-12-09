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
        Schema::create('pluses', function (Blueprint $table) {
            $table->id();
    
            // ربط الحقول بالمفاتيح الأجنبية مع ON DELETE CASCADE
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')
                  ->references('id')
                  ->on('stages')
                  ->onDelete('cascade'); // حذف الحقول عند حذف المرحلة
    
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')
                  ->references('id')
                  ->on('campaigns')
                  ->onDelete('cascade'); // حذف الحقول عند حذف الحملة
    
            $table->unsignedBigInteger('tree4_code')->nullable();
            $table->foreignId('tree4_id')
                  ->constrained()
                  ->cascadeOnDelete(); // حذف الحقول عند حذف الحاج
    
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
        Schema::dropIfExists('pluses');
    }
};