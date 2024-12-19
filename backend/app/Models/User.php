<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
  use HasFactory;

  protected $table = "studx_users";

  protected $fillable = [
    "username",
    "password_hash",
    "full_name",
    "email",
    "phone_number",
    "birth_date",
  ];
}
