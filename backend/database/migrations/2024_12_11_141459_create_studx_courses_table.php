<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create("studx_courses", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string("code", 20)->unique();
      $table->string("name", 250);
      $table->string("subject_name", 250)->nullable();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists("studx_courses");
  }
};
