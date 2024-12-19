<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseOfUser extends Model
{
  use HasFactory;

  protected $table = "studx_courses_of_user";

  protected $fillable = [
    "user_id",
    "course_id",
  ];
}
