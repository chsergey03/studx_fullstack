<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
  use HasFactory;

  protected $table = "studx_tasks";

  protected $fillable = [
    "course_id",
    "name",
    "theme",
    "deadline",
    "grade_max_value"
  ];
}
