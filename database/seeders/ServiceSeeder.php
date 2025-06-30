<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء بعض مزودي الخدمة
        $providers = User::factory()->count(5)->provider()->create();

        // إنشاء فئات
        $categories = Category::factory()->count(5)->create();

        // لكل مزود خدمة، أنشئ 2-4 خدمات ضمن فئات عشوائية
        foreach ($providers as $provider) {
            Service::factory()
                ->count(rand(2, 4))
                ->for($provider, 'provider')
                ->for($categories->random(), 'category')
                ->create();
        }
    }
}
