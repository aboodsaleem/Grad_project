<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all service providers
        $providers = User::where('role', 'service_provider')->get();

        // If no providers, skip seeding
        if ($providers->isEmpty()) {
            $this->command->info('No service providers found. Skipping ServiceSeeder.');
            return;
        }

        // Define example service types
        $types = ['Electrical', 'Maintenance', 'Repairing', 'Cleaning', 'Washing'];

        // Add services for each provider
        foreach ($providers as $provider) {
            foreach ($types as $type) {
                Service::create([
                    'service_provider_id' => $provider->id,
                    'name' => "$type Service by {$provider->name}",
                    'serviceType' => $type,
                    'description' => "This is a $type service offered by {$provider->name}.",
                    'price' => rand(20, 100),
                ]);
            }
        }
    }
}
