<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\TasksController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix("users")->group(function () {
  Route::post("/", [UserController::class, "createUser"]);
  Route::post("/authenticate", [UserController::class, "authenticateUser"]);
  Route::patch("/{id}", [UserController::class, "updateUserLogin"]);
  Route::delete("/{id}", [UserController::class, "deleteUser"]);
});

Route::prefix("courses")->group(function () {
  Route::get("/", [CoursesController::class, "getAllCourses"]);
  Route::get("/course/{courseId}", [CoursesController::class, "getCourse"]);
});

Route::prefix("tasks")->group(function () {
  Route::get("/", [TasksController::class, "getAllTasks"]);
  Route::get("{courseId}", [TasksController::class, "getAllTasksOfCourse"]);
  Route::get("task/{taskId}", [TasksController::class, "getTask"]);
});

Route::prefix("courses_of_user")->group(function () {
  Route::post("/", [CoursesController::class, "createRecord"]);
  Route::get("/", [CoursesController::class, "getAllRecords"]);
  Route::get("/course/{courseId}", [CoursesController::class, "getRecord"]);
  Route::patch("/course/{courseId}", [CoursesController::class, "updateRecord"]);
  Route::delete("/course/{courseId}", [CoursesController::class, "deleteRecord"]);
});
