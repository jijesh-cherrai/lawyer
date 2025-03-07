<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CaseDiaries extends Migration
{
    public function up()
    {
        Schema::create('case_diaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('court_id');
            $table->text('party_names');
            $table->string('mobile',15)->nullable();
            $table->string('opposit_lawyer')->nullable();
            $table->text('notes')->nullable();
            $table->date('upcoming_case_date')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();

            // Define the foreign key constraint
            // $table->foreign('court_id')->references('id')->on('courts');
        });
    }

    public function down()
    {
        // Schema::table('case_diaries', function (Blueprint $table) {
        //     $table->dropForeign(['court_id']);
        // });
        Schema::dropIfExists('case_diaries');
    }
}
