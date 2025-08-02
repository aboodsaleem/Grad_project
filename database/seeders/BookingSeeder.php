<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run()
    {
        // الحصول على بعض مزودي الخدمة والعملاء والخدمات
        $serviceProviders = User::where('role', 'service_provider')->pluck('id')->toArray();
        $customers = User::where('role', 'customer')->pluck('id')->toArray();
        $services = Service::pluck('id', 'service_provider_id')->toArray();

        if(empty($serviceProviders) || empty($customers) || empty($services)){
            $this->command->info("لا يوجد بيانات كافية من مزودي الخدمة، العملاء أو الخدمات");
            return;
        }

        // توليد 20 حجز عشوائي
        for ($i = 0; $i < 20; $i++) {
            // اختيار عشوائي لمزود الخدمة
            $providerId = $serviceProviders[array_rand($serviceProviders)];

            // اختيار عشوائي لخدمة مزود الخدمة هذا
            $serviceId = null;
            foreach ($services as $spId => $sId) {
                if ($spId == $providerId) {
                    $serviceId = $sId;
                    break;
                }
            }
            if (!$serviceId) continue; // اذا ما وجد خدمة لهذا المزود تجاهل

            Booking::create([
                'user_id' => $customers[array_rand($customers)],   // عميل عشوائي
                'service_provider_id' => $providerId,
                'service_id' => $serviceId,
                'booking_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'status' => ['pending', 'confirmed', 'completed', 'cancelled'][array_rand(['pending', 'confirmed', 'completed', 'cancelled'])],
                'description' => 'Sample booking description #' . Str::random(5),
            ]);
        }

        $this->command->info("تم إنشاء بيانات تجريبية للحجوزات");
    }
}
