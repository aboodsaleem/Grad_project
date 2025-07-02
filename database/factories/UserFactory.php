<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $roles = ['admin', 'service_provider', 'customer'];
        $status = ['active', 'inactive'];

        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // كلمة المرور الافتراضية
            'photo' => null,
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'role' => $this->faker->randomElement($roles),
            'status' => $this->faker->randomElement($status),
            'remember_token' => Str::random(10),
        ];
    }

    public function provider()
{
    return $this->state(fn () => [
        'role' => 'service_provider',
    ]);
}

public function customer()
{
    return $this->state(fn () => [
        'role' => 'customer',
    ]);
}

public function admin()
{
    return $this->state(fn () => [
        'role' => 'admin',
    ]);
}


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
