<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create("studx_courses_of_user", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->unsignedBigInteger("user_id");
      $table->unsignedBigInteger("course_id");
      $table->string("custom_course_name", 250)->nullable();

      $table->foreign("user_id")->references("id")->on("studx_users");
      $table->foreign("course_id")->references("id")->on("studx_courses");
    });
  }

  public function down(): void
  {
    Schema::dropIfExists("studx_courses_of_user");
  }
};
