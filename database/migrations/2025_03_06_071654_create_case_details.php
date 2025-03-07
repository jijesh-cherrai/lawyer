<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('case_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('case_number');
            $table->unsignedBigInteger('case_type');
            $table->unsignedBigInteger('case_diary_id');
            $table->timestamps();
            // $table->foreign('case_type')->references('id')->on('case_types');
            // $table->foreign('case_diary_id')->references('id')->on('case_diaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('case_details', function (Blueprint $table) {
        //     $table->dropForeign(['case_type', 'case_diary_id']);
        // });
        Schema::dropIfExists('case_details');
    }
};
