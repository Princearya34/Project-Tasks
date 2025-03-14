<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'password', 'image'];


public static function rules()
{
    return [
        'name' => ['required', 'regex:/^[A-Za-z][A-Za-z _]+$/'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'min:6'], // Keep password
        'phone' => ['required', 'digits:10', 'unique:users']
    ];
}

}
