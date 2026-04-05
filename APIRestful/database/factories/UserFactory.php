<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



//esta clase es para crear usuarios falsos
/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {

        $verificado = fake()->randomElement([User::USUARIO_VERIFICADO, User::USUARIO_NO_VERIFICADO]);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('secret'),
            'remember_token' => Str::random(40),


            'verified' => $verificado,
            'verification_token' => $verificado == User::USUARIO_VERIFICADO ? null : User::generarVerificationToken(),

            'admin' => fake()->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR]),
        ];
    }
}
