<?php

namespace App\Http\Controllers;

use App\Models\Task;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Schema(
 *   schema="tasks",
 *   type="object",
 *   title="Задача",
 *   description="Схема задачи",
 *   required={"id", "course_id", "name"},
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Идентификатор задачи",
 *     example=1
 *   ),
 *   @OA\Property(
 *     property="course_id",
 *     type="string",
 *     description="Идентификатор курса",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Название задачи",
 *     example="HTML & CSS Basics"
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     type="string",
 *     format="date-time",
 *     description="Дата и время создания задачи",
 *     example="2024-12-19T12:34:56Z"
 *   ),
 *   @OA\Property(
 *     property="updated_at",
 *     type="string",
 *     format="date-time",
 *     description="Дата и время последнего обновления задачи",
 *     example="2024-12-19T12:34:56Z"
 *   )
 * )
 */
class TasksController extends Controller
{
  /**
   * @OA\Get(
   *   path="/courses/{courseId}/tasks",
   *   summary="Получение всех задач курса",
   *   tags={"tasks"},
   *   @OA\Parameter(
   *     name="courseId",
   *     in="path",
   *     required=true,
   *     description="Идентификатор курса"
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Успешное получение всех задач курса",
   *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/tasks"))
   *   ),
   *   @OA\Response(
   *     response=500,
   *     description="Ошибка сервера",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Ошибка сервера"),
   *       @OA\Property(property="details", type="string", example="error details")
   *     )
   *   )
   * )
   */
  public function getAllTasksOfCourse(int $courseId): JsonResponse
  {
    try {
      $tasks = Task::query()
        ->where("course_id", $courseId)
        ->get();

      return response()->json([$tasks]);
    } catch (Exception $e) {
      return response()
        ->json(
          [
            "message" => "Ошибка сервера",
            "details" => $e->getMessage(),
          ],
          500
        );
    }
  }

  /**
   * @OA\Get(
   *   path="/tasks/{taskId}",
   *   summary="Получение информации о задаче",
   *   tags={"tasks"},
   *   @OA\Parameter(
   *     name="taskId",
   *     in="path",
   *     required=true,
   *     description="Идентификатор задачи",
   *     @OA\Schema(type="integer", example=1)
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Успешное получение информации о задаче",
   *     @OA\JsonContent(ref="#/components/schemas/tasks")
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Задача не найдена",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Задача не найдена"),
   *       @OA\Property(property="details", type="string", example="error details")
   *     )
   *   ),
   *   @OA\Response(
   *     response=500,
   *     description="Ошибка сервера",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Ошибка сервера"),
   *       @OA\Property(property="details", type="string", example="error details")
   *     )
   *   )
   * )
   */
  public function getTask(int $taskId): JsonResponse
  {
    try {
      $task = Task::query()
        ->where("id", $taskId)
        ->first();

      return response()->json([$task]);
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Задача не найдена",
            "details" => $e->getMessage(),
          ],
          404
        );
    } catch (Exception $e) {
      return response()
        ->json(
          [
            "message" => "Ошибка сервера",
            "details" => $e->getMessage(),
          ],
          500
        );
    }
  }
}
