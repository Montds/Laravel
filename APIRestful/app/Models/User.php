<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */

     use HasFactory, Notifiable;

    const string USUARIO_VERIFICADO = '1';
    const string  USUARIO_NO_VERIFICADO = '0';

    const string  USUARIO_ADMINISTRADOR = 'true';
    const string  USUARIO_REGULAR = 'false';

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];
    public function esVerificado(): bool
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }
    public function esAdministrador(): bool
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }


    //generar token
    public static function generarVerificationToken(): string
    {
        return Str::random(40);
    }

  /*  protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
  */
}
