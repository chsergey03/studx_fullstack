<?php

namespace App\Http\Controllers;

use App\Models\CourseOfUser;

use Exception;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 *   schema="courses_of_user",
 *   type="object",
 *   title="courses_of_user",
 *   description="Схема курсов пользователя",
 *   required={"id", "user_id", "course_id"},
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Идентификатор записи",
 *     example=1
 *   ),
 *   @OA\Property(
 *     property="user_id",
 *     type="integer",
 *     description="Идентификатор пользователя",
 *     example=1
 *   ),
 *   @OA\Property(
 *     property="course_id",
 *     type="integer",
 *     description="Идентификатор курса",
 *     example=6
 *   ),
 *   @OA\Property(
 *     property="custom_course_name",
 *     type="string",
 *     nullable=true,
 *     description="Пользовательское название курса",
 *     example="Мой курс"
 *   ),
 *   @OA\Property(
 *      property="created_at",
 *      type="string",
 *      format="date-time",
 *      description="Дата и время создания записи",
 *      example="2024-12-20T10:15:30Z"
 *    ),
 *    @OA\Property(
 *      property="updated_at",
 *      type="string",
 *      format="date-time",
 *      description="Дата и время последнего обновления записи",
 *      example="2024-12-21T14:22:45Z"
 *    )
 * )
 *
 * @OA\Tag(
 *   name="courses_of_user",
 *   description="Методы, связанные с курсами пользователя"
 * )
 */
class CoursesOfUserController extends Controller
{
  /**
   * @OA\Post(
   *   path="/courses_of_user",
   *   summary="Создание записи о курсе пользователя",
   *   tags={"courses_of_user"},
   *   @OA\RequestBody(
   *     required=true,
   *     @OA\JsonContent(
   *       required={"user_id", "course_id"},
   *       @OA\Property(
   *         property="user_id",
   *         type="integer",
   *         example=1,
   *         description="Идентификатор пользователя"
   *       ),
   *       @OA\Property(
   *         property="course_id",
   *         type="integer",
   *         example=6,
   *         description="Идентификатор курса"
   *       ),
   *       @OA\Property(
   *         property="custom_course_name",
   *         type="string",
   *         nullable=true,
   *         example="Мой курс",
   *         description="Пользовательское название курса"
   *       )
   *     )
   *   ),
   *   @OA\Response(
   *     response=201,
   *     description="Запись создана",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Запись создана"),
   *       @OA\Property(property="data", ref="#/components/schemas/courses_of_user")
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
  public function createRecord(Request $request): JsonResponse
  {
    try {
      $validatedRequest = $request->validate([
        "user_id" => "required|exists:studx_users,id",
        "course_id" => "required|exists:studx_courses,id",
        "custom_course_name" => "nullable|string|max:250",
      ]);

      $courseToCreate = CourseOfUser::create($validatedRequest);

      return response()
        ->json(
          [
            "message" => "Запись создана",
            "data" => $courseToCreate
          ],
          201
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

  /**
   * @OA\Patch(
   *   path="/courses_of_user/{id}",
   *   summary="Обновление записи о курсе пользователя",
   *   tags={"courses_of_user"},
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     description="Идентификатор записи",
   *     @OA\Schema(type="integer", example=1)
   *   ),
   *   @OA\RequestBody(
   *     required=true,
   *     @OA\JsonContent(
   *       @OA\Property(
   *         property="custom_course_name",
   *         type="string",
   *         nullable=true,
   *         example="Обновленное название курса",
   *         description="Пользовательское название курса"
   *       )
   *     )
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Запись обновлена",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Запись обновлена"),
   *       @OA\Property(property="custom_course_name", type="string", example="Обновленное название курса")
   *     )
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Запись не найдена",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Запись не найдена"),
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
  public function updateRecord(int $id, Request $request): JsonResponse
  {
    try {
      $validatedRequest = $request->validate([
        "custom_course_name" => "nullable|string|max:250",
      ]);

      $recordToUpdate = CourseOfUser::findOrFail($id);

      $recordToUpdate->update($validatedRequest);

      return response()
        ->json(
          [
            "message" => "Запись обновлена",
            "custom_course_name" => $recordToUpdate->custom_course_name
          ]
        );
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Запись не найдена",
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

  /**
   * @OA\Get(
   *   path="/courses_of_user",
   *   summary="Получение всех записей о курсах пользователей",
   *   tags={"courses_of_user"},
   *   @OA\Response(
   *     response=200,
   *     description="Список записей",
   *     @OA\JsonContent(
   *       type="array",
   *       @OA\Items(ref="#/components/schemas/courses_of_user")
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
  public function getAllRecords(): JsonResponse
  {
    try {
      $records = CourseOfUser::all();

      return response()->json([$records]);
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
   *   path="/courses_of_user/{id}",
   *   summary="Получение записи о курсе пользователя",
   *   tags={"courses_of_user"},
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     description="Идентификатор записи",
   *     @OA\Schema(type="integer", example=1)
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Запись найдена",
   *     @OA\JsonContent(ref="#/components/schemas/courses_of_user")
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Запись не найдена",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Запись не найдена"),
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
  public function getRecord(int $id): JsonResponse
  {
    try {
      $record = CourseOfUser::findOrFail($id);

      return response()->json([$record]);
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Запись не найдена",
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

  /**
   * @OA\Delete(
   *   path="/courses_of_user/{id}",
   *   summary="Удаление записи о курсе пользователя",
   *   tags={"courses_of_user"},
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     description="Идентификатор записи",
   *     @OA\Schema(type="integer", example=1)
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Запись удалена",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Запись удалена")
   *     )
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Запись не найдена",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Запись не найдена"),
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
  public function deleteRecord(int $id): JsonResponse
  {
    try {
      $recordToDelete = CourseOfUser::findOrFail($id);

      $recordToDelete->delete();

      return response()
        ->json(
          [
            "message" => "Запись удалена",
          ]
        );
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Запись не найдена",
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
