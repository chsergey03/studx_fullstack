<?php

namespace App\Http\Controllers;

use App\Models\User;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Schema(
 *   schema="users",
 *   type="object",
 *   title="users",
 *   description="Схема пользователей",
 *   required={"id", "login", "password_hash"},
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Идентификатор пользователя",
 *     example=1
 *   ),
 *   @OA\Property(
 *     property="login",
 *     type="string",
 *     description="Логин пользователя",
 *     example="mark_brown"
 *   ),
 *   @OA\Property(
 *     property="password_hash",
 *     type="string",
 *     description="Хэш пароля",
 *     example="$2y$10$zNMhNQlZ6s08xWQZPp0GEOo./6z8bMQVzDgmEFOzWwnXTtn5OwR4K"
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     type="string",
 *     format="date-time",
 *     description="Дата и время создания пользователя",
 *     example="2024-12-20T10:15:30Z"
 *   ),
 *   @OA\Property(
 *     property="updated_at",
 *     type="string",
 *     format="date-time",
 *     description="Дата и время последнего обновления пользователя",
 *     example="2024-12-21T14:22:45Z"
 *   )
 * )
 *
 * @OA\Tag(
 *   name="users",
 *   description="Методы, связанные с пользователями"
 * )
 */
class UserController extends Controller
{
  /**
   * @OA\Post(
   *   path="/users",
   *   summary="Создание нового пользователя",
   *   tags={"users"},
   *   @OA\RequestBody(
   *     required=true,
   *     @OA\JsonContent(
   *       required={"login", "password"},
   *       @OA\Property(property="login", type="string", example="mark_brown", description="Логин пользователя"),
   *       @OA\Property(property="password", type="string", example="password123", description="Пароль пользователя")
   *     )
   *   ),
   *   @OA\Response(
   *     response=201,
   *     description="Новый пользователь создан",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Новый пользователь создан"),
   *       @OA\Property(property="user_id", type="integer", example=1),
   *       @OA\Property(property="login", type="string", example="mark_brown")
   *     )
   *   ),
   *   @OA\Response(
   *      response=400,
   *      description="Ошибка валидации",
   *      @OA\JsonContent(
   *        @OA\Property(property="message", type="string", example="Ошибка валидации")
   *      )
   *    ),
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
  public function createUser(Request $request): JsonResponse
  {
    try {
      $validatedRequest = $request->validate([
        "login" => "required|unique:users,login|string|max:250",
        "password" => "required|string|max:250",
      ]);

      $validatedRequest["password"] = bcrypt($validatedRequest["password"]);

      $userToCreate = User::create([
        "login" => $validatedRequest["login"],
        "password_hash" => $validatedRequest["password"],
      ]);

      return response()
        ->json(
          [
            "message" => "Новый пользователь создан",
            "user_id" => $userToCreate->id,
            "login" => $userToCreate->login,
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
   *   path="/users/{id}",
   *   summary="Обновление логина пользователя",
   *   tags={"users"},
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     description="Идентификатор пользователя",
   *     @OA\Schema(type="integer", example=1)
   *   ),
   *   @OA\RequestBody(
   *     required=true,
   *     @OA\JsonContent(
   *       @OA\Property(property="login", type="string", example="john_doe", description="Логин пользователя")
   *     )
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Логин пользователя обновлён",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Логин пользователя обновлён"),
   *       @OA\Property(property="login", type="string", example="john_doe")
   *     )
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Пользователь не найден",
   *     @OA\JsonContent(
   *        @OA\Property(property="message", type="string", example="Пользователь не найден"),
   *        @OA\Property(property="details", type="string", example="error details")
   *      )
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
  public function updateUserLogin(int $id, Request $request): JsonResponse
  {
    try {
      $validatedRequest = $request->validate([
        "login" => "sometimes|unique:users,login,$id|string|max:250",
      ]);

      $userToUpdate = User::findOrFail($id);

      $userToUpdate->update($validatedRequest);

      return response()
        ->json(
          [
            "message" => "Логин пользователя обновлён"
          ]
        );
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Пользователь не найден",
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
   * @OA\Post(
   *   path="/users/authenticate",
   *   summary="Аутентификация пользователя",
   *   tags={"users"},
   *   @OA\RequestBody(
   *     required=true,
   *     @OA\JsonContent(
   *       required={"login", "password"},
   *       @OA\Property(
   *         property="login",
   *         type="string",
   *         example="mark_brown",
   *         description="Логин, введённый пользователем"
   *       ),
   *       @OA\Property(
   *         property="password",
   *         type="string",
   *         example="password123",
   *         description="Пароль, введённый пользователем"
   *       )
   *     )
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Пользователь успешно прошёл аутентификацию",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Пользователь успешно прошёл аутентификацию"),
   *       @OA\Property(property="user_id", type="integer", example=1),
   *       @OA\Property(property="login", type="string", example="mark_brown")
   *     )
   *   ),
   *   @OA\Response(
   *     response=401,
   *     description="Неверный логин или пароль",
   *     @OA\JsonContent(
   *       @OA\Property(property="error", type="string", example="Неверный логин или пароль")
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
  public function authenticateUser(Request $request): JsonResponse
  {
    try {
      $validatedRequest = $request->validate([
        "login" => "required|string|max:250",
        "password" => "required|string|max:250",
      ]);

      $userToAuthenticate = User::query()
        ->where("login", $validatedRequest["login"])
        ->first();

      if (!$userToAuthenticate ||
        !Hash::check(
          $validatedRequest["password"],
          $userToAuthenticate->password_hash
        )
      ) {
        return response()
          ->json(
            [
              "message" => "Неверный логин или пароль",
            ],
            401
          );
      } else {
        return response()
          ->json(
            [
              "message" => "Пользователь успешно прошёл аутентификацию",
              "user_id" => $userToAuthenticate->id,
              "login" => $userToAuthenticate->login,
            ]
          );
      }
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
   *   path="/users/{id}",
   *   summary="Удаление пользователя",
   *   tags={"users"},
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     description="Идентификатор пользователя",
   *     @OA\Schema(type="integer")
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Пользователь удалён",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Пользователь удалён")
   *     )
   *   ),
   *   @OA\Response(
   *     response=404,
   *     description="Пользователь не найден",
   *     @OA\JsonContent(
   *       @OA\Property(property="message", type="string", example="Пользователь не найден"),
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
  public function deleteUser(int $id): JsonResponse
  {
    try {
      $userToDelete = User::findOrFail($id);

      $userToDelete->delete();

      return response()
        ->json(
          [
            "message" => "Пользователь удалён",
          ]
        );
    } catch (ModelNotFoundException $e) {
      return response()
        ->json(
          [
            "message" => "Пользователь не найден",
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
