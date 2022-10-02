<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_details', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->string('exam_type');
            $table->string('reg_no');
            $table->year('passing_year');
            $table->string('oraganization');
            $table->unsignedSmallInteger('obtained_marks');
            $table->unsignedSmallInteger('total_marks');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('academic_details');
    }
}
