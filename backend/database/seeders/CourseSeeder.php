<?php

namespace Database\Seeders;

use App\Models\Course;

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
  public function run(): void
  {
    $courses = [
      [
        "code" => "PHP101",
        "name" => "Introduction to PHP",
        "subject_name" => "Programming Basics",
      ],
      [
        "code" => "JS201",
        "name" => "JavaScript for Beginners",
        "subject_name" => "Frontend Development",
      ],
      [
        "code" => "DB301",
        "name" => "Mastering SQL Databases",
        "subject_name" => "Database Management",
      ],
      [
        "code" => "ML401",
        "name" => "Introduction to Machine Learning",
        "subject_name" => "Artificial Intelligence",
      ],
      [
        "code" => "WEB102",
        "name" => "Responsive Web Design",
        "subject_name" => "UI/UX Design",
      ],
      [
        "code" => "JAVA202",
        "name" => "Java for Enterprise Applications",
        "subject_name" => "Backend Development",
      ],
    ];

    foreach ($courses as $course) {
      Course::create($course);
    }
  }
}
