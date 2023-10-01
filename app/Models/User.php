<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'token_time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'name' => 'encrypted',
        'email' => 'encrypted',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public  function build(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
        ];
    }
    public static function getUserDecripted($email)
    {
        $users = User::all();
        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]['email'] === $email) {
                return $users[$i];
            }
        }

        return null;
    }
}
