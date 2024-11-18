<?php

namespace App\Http\Controllers;

class StaticUsersController extends Controller
{
  private const USERS = [
    [
      "id" => 1,
      "nickname" => "john_doe",
      "firstName" => "John",
      "secondName" => "Doe",
      "email" => "john.doe@yandex.ru",
      "phoneNumber" => "+7 (900) 123-45-67"
    ],
    [
      "id" => 2,
      "nickname" => "jane_smith",
      "firstName" => "Jane",
      "secondName" => "Smith",
      "email" => "jane.smith@yandex.ru",
      "phoneNumber" => "+7 (901) 234-56-78"
    ],
    [
      "id" => 3,
      "nickname" => "alex_brown",
      "firstName" => "Alex",
      "secondName" => "Brown",
      "email" => "alex.brown@yandex.ru",
      "phoneNumber" => "+7 (902) 345-67-89"
    ],
  ];

  public function index()
  {
    return self::USERS;
  }

  public function info($userId)
  {
    return current(array_filter(
        self::USERS,
        function ($user) use ($userId) {
          return $user["id"] == $userId;
        })
    );
  }
}
