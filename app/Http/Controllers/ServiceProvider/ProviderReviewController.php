<?php
namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ProviderReviewController extends Controller
{
    public function index()
    {
        // جلب كل التقييمات الخاصة بخدمات مزود الخدمة الحالي
        $reviews = Review::whereHas('service', function ($query) {
            $query->where('user_id', Auth::id());
        })->latest()->paginate(10);

        return view('provider.reviews.index', compact('reviews'));
    }

    public function show($id)
    {
        $review = Review::where('id', $id)
            ->whereHas('service', function ($query) {
                $query->where('user_id', Auth::id());
            })->firstOrFail();

        return view('provider.reviews.show', compact('review'));
    }
}
