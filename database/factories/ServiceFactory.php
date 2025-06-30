<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 20, 500),
            'photo' => null,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'provider_id' => User::factory()->provider(),   // ينشئ مزود خدمة
            'category_id' => Category::factory(),           // ينشئ فئة
        ];
    }
}
