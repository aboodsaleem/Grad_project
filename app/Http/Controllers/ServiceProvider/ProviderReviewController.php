<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ProviderReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:service_provider']);
    }

    // دخول /provider/reviews → يعيد التوجيه للداشبورد تبويب #reviews
    public function index()
    {
        return redirect()->to(route('provider.dashboard') . '#reviews');
    }

    // عرض تقييم واحد → نتحقق الملكية ثم نعيد التوجيه لنفس التبويب
    public function show(Review $review)
    {
        abort_if($review->service_provider_id !== auth()->id(), 403);

        // لو حبيت تميّزي تقييم معيّن لاحقاً، أضيفي query مثل ?review={id}
        return redirect()->to(route('provider.dashboard') . '#reviews');
        // مثال مستقبلي:
        // return redirect()->to(route('provider.dashboard') . '#reviews?review=' . $review->id);
    }
}
