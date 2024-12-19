<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Task;

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
  public function run(): void
  {
    $tasksByCourse = [
      "PHP101" => [
        ["name" => "Basic PHP Syntax", "theme" => "Syntax", "grade_max_value" => 10],
        ["name" => "Control Structures", "theme" => "Logic", "grade_max_value" => 15],
        ["name" => "Functions in PHP", "theme" => "Functions", "grade_max_value" => 20],
      ],
      "JS201" => [
        ["name" => "Variables and Types", "theme" => "Basics", "grade_max_value" => 10],
        ["name" => "DOM Manipulation", "theme" => "Frontend", "grade_max_value" => 15],
        ["name" => "Event Handling", "theme" => "Interaction", "grade_max_value" => 20],
      ],
      "DB301" => [
        ["name" => "SQL Basics", "theme" => "Queries", "grade_max_value" => 10],
        ["name" => "Database Design", "theme" => "Structure", "grade_max_value" => 15],
        ["name" => "Joins and Relations", "theme" => "Advanced Queries", "grade_max_value" => 20],
      ],
      "ML401" => [
        ["name" => "Linear Regression", "theme" => "Statistics", "grade_max_value" => 10],
        ["name" => "Supervised Learning", "theme" => "Classification", "grade_max_value" => 15],
        ["name" => "Unsupervised Learning", "theme" => "Clustering", "grade_max_value" => 20],
      ],
      "WEB102" => [
        ["name" => "HTML & CSS Basics", "theme" => "Frontend", "grade_max_value" => 10],
        ["name" => "Flexbox and Grid", "theme" => "Layout", "grade_max_value" => 15],
        ["name" => "Accessibility Design", "theme" => "UI/UX", "grade_max_value" => 20],
      ],
      "JAVA202" => [
        ["name" => "Java Basics", "theme" => "OOP", "grade_max_value" => 10],
        ["name" => "Spring Framework", "theme" => "Backend", "grade_max_value" => 15],
        ["name" => "REST APIs in Java", "theme" => "Web Services", "grade_max_value" => 20],
      ],
    ];

    $startDate = "2024-09-15";

    foreach ($tasksByCourse as $courseCode => $tasks) {
      $course = Course::where("code", $courseCode)->first();

      if ($course) {
        $currentDate = $startDate;

        foreach ($tasks as $task) {
          Task::create([
            "course_id" => $course->id,
            "name" => $task["name"],
            "theme" => $task["theme"],
            "deadline" => $currentDate,
            "grade_max_value" => $task["grade_max_value"],
          ]);

          $currentDate = date("Y-m-d H:i:s", strtotime($currentDate . " +14 days"));
        }
      }
    }
  }
}
