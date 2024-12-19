<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("studx_tasks", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("course_id");
            $table->string("name", 250);
            $table->string("theme", 250)->nullable();
            $table->dateTime("deadline")->nullable();
            $table->integer("grade_max_value")->nullable();

            $table->foreign("course_id")->references("id")->on("studx_courses");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tasks");
    }
};
