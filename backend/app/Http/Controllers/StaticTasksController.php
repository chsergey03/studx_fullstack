<?php

namespace App\Http\Controllers;

class StaticTasksController extends Controller
{
  private const TASKS = [
    [
      "id" => 1,
      "courseId"  => 1,
      "name" => "Learn basic sorting algorithms like Bubble Sort and Insertion Sort.",
      "deadline" => "2024-12-01",
    ],
    [
      "id" => 2,
      "courseId"  => 1,
      "name" => "Implement basic data structures such as stacks, queues, and linked lists.",
      "deadline" => "2024-12-10",
    ],
    [
      "id" => 3,
      "courseId"  => 1,
      "name" => "Write simple Python scripts and understand basic syntax.",
      "deadline" => "2024-12-15",
    ],
    [
      "id" => 4,
      "courseId" => 2,
      "name" => "Analyze the time complexity of Merge Sort and Quick Sort.",
      "deadline" => "2024-12-20",
    ],
    [
      "id" => 5,
      "courseId" => 2,
      "name" => "Design and implement a binary search tree with basic operations (insert, delete, search).",
      "deadline" => "2025-01-05",
    ],
    [
      "id" => 6,
      "courseId" => 2,
      "name" => "Solve problems using graph algorithms like BFS and DFS.",
      "deadline" => "2025-01-15",
    ],
    [
      "id" => 7,
      "courseId" => 3,
      "name" => "Build a simple static website using HTML and CSS.",
      "deadline" => "2024-12-20",
    ],
    [
      "id" => 8,
      "courseId" => 3,
      "name" => "Create a dynamic webpage with JavaScript to handle user input.",
      "deadline" => "2025-01-05",
    ],
    [
      "id" => 9,
      "courseId" => 3,
      "name" => "Develop a basic CRUD application using a web framework of your choice (e.g., Flask, Express).",
      "deadline" => "2025-01-15",
    ],
  ];

  private const COURSES = [
    [
      "id" => 1,
      "title"  => "Introduction to Computer Science",
    ],
    [
      "id" => 2,
      "title"  => "Data Structures and Algorithms",
    ],
    [
      "id" => 3,
      "title"  => "Web Development",
    ],
  ];

  public function index($courseId): array
  {
    return array_values(array_filter(
      self::TASKS,
      fn($task) => $task["courseId"] == $courseId
    ));
  }

  public function info($taskId): array
  {
    $task = current(array_filter(
      self::TASKS,
      fn($task) => $task["id"] == $taskId
    ));

    if (!$task) {
      return [];
    }

    $course = current(array_filter(
      self::COURSES,
      fn($course) => $course["id"] == $task["courseId"]
    ));

    $courseTitle = $course["title"] ?? null;

    $task["courseTitle"] = $courseTitle;

    return $task;
  }
}
