<?php

namespace App\Http\Controllers;

class StaticCoursesController extends Controller
{
  private const COURSES = [
    [
      "id" => 1,
      "name" => "Introduction to Computer Science",
      "description" => "Basic principles of computer science, including algorithms and data structures.",
    ],
    [
      "id" => 2,
      "name" => "Data Structures and Algorithms",
      "description" => "Study of data structures like stacks, queues, and algorithms.",
    ],
    [
      "id" => 3,
      "name" => "Web Development",
      "description" => "An introduction to web development with HTML, CSS, and JavaScript.",
    ],
  ];

  public function index(): array
  {
    return self::COURSES;
  }

  public function info($courseId): array
  {
    return current(array_filter(
        self::COURSES,
        function ($course) use ($courseId) {
          return $course["id"] == $courseId;
        })
    );
  }
}
