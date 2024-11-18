<?php

use App\Http\Controllers\StaticCoursesController;
use App\Http\Controllers\StaticTasksController;
use App\Http\Controllers\StaticUsersController;

use Illuminate\Support\Facades\Route;

Route::prefix("courses")->group(function () {
  Route::get("/", [StaticCoursesController::class, "index"]);
  Route::get("/course/{courseId}", [StaticCoursesController::class, "info"]);
});

Route::prefix("tasks")->group(function () {
  Route::get("{courseId}", [StaticTasksController::class, "index"]);
  Route::get("task/{taskId}", [StaticTasksController::class, "info"]);
});

Route::prefix("users")->group(function () {
  Route::get("/", [StaticUsersController::class, "index"]);
  Route::get("/user/{userId}", [StaticUsersController::class, "info"]);
});
