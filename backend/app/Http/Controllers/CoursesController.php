<?php

namespace App\Http\Controllers;

use App\Models\Course;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Info(
 *   title="Документация StudX API",
 *   version="1.0.0",
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8080/api",
 *   description="Локальный сервер"
 * )
 *
 * @OA\Schema(
 *   schema="courses",
 *   type="object",
 *   title="Курс",
 *   description="Схема курса",
 *   required={"id", "code", "name"},
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Идентификатор курса",
 *     example=1
 *   ),
 *   @OA\Property(
 *      property="code",
 *      type="string",
 *      description="Код курса",
 *      example="WEB102"
 *    ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Название курса",
 *     example="Responsive Web Design"
 *   ),
 *   @OA\Property(
 *     property="subject_name",
 *     type="string",
 *     nullable=true,
 *     description="Название предмета",
 *     example="UI/UX Design"
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     type="string",
 *     format="date-time",
 *     description="Дата и время создания курса",
 *     example="2024-12-19T12:34:56Z"
 *   ),
 *   @OA\Property(
 *     property="updated_at",
 *     type="string",
 *     format="date-time",
 *     description="Дата и время последнего обновления курса",
 *     example="2024-12-19T12:34:56Z"
 *   )
 * )
 */
class CoursesController extends Controller
{
  /**
   * @OA\Get(
   *   path="/courses",
   *   summary="Получение списка всех курсов",
   *   tags={"courses"},
   *   @OA\Response(
   *     response=200,
   *     description="Успешное получение списка всех курсов",
   *     @OA\JsonContent(
   *       type="array",
   *       @OA\Items(ref="#/components/schemas/courses")
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
  public function getAllCourses(): JsonResponse
  {
    try {
      $courses = Course::all();

      return response()->json($courses);
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
   *   path="/courses/{id}",
   *   summary="Получение информации о конкретном курсе",
   *   tags={"courses"},
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     description="Идентификатор курса",
   *     @OA\Schema(type="integer", example=1)
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Успешное получение информации о курсе",
   *     @OA\JsonContent(
   *       ref="#/components/schemas/courses"
   *     )
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Курс не найден",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Курс не найден"),
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
  public function getCourse(int $id): JsonResponse
  {
    try {
      $course = Course::findOrFail($id);

      return response()->json($course);
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Курс не найден",
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
