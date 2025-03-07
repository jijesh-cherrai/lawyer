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
        Schema::create('case_followups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('case_diary_id');
            $table->integer('advocate_attended')->nullable();
            $table->date('next_hearing');
            $table->text('notes')->nullable();
            $table->timestamps();

            // $table->foreign('case_diary_id')->references('id')->on('case_diaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('case_followups', function (Blueprint $table) {
        //     $table->dropForeign(['case_diary_id']);
        // });
        Schema::dropIfExists('case_followups');
    }
};
