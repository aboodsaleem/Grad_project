<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceFavoriteController extends Controller
{
    /**
     * صفحة المفضلة المستقلة
     * تعرض جميع خدمات المزوّدين الذين أضافهم المستخدم إلى المفضلة.
     */
    public function page()
    {
        // IDs المزوّدين المفضّلين للمستخدم الحالي
        $providerIds = Favorite::where('user_id', Auth::id())
            ->pluck('service_provider_id');

        // جميع خدمات هؤلاء المزوّدين
        $Favoriteservices = Service::with('serviceProvider')
            ->whereIn('service_provider_id', $providerIds)
            ->latest()
            ->get();

        return view('customer.favorite.favorite', compact('Favoriteservices'));
    }

    /**
     * قلب المفضلة: إضافة/إزالة مزوّد (Toggle)
     * يستقبل رقم المزوّد (id) ويضيفه أو يزيله من مفضلة المستخدم الحالي.
     */
    public function toggle($providerId)
    {
        // هل هذا المزوّد موجود بالفعل في مفضلتي؟
        $fav = Favorite::where('user_id', Auth::id())
            ->where('service_provider_id', $providerId)
            ->first();

        if ($fav) {
            // موجود -> نحذفه
            $fav->delete();
            return response()->json(['favorited' => false]);
        }

        // غير موجود -> نضيفه
        Favorite::create([
            'user_id'             => Auth::id(),
            'service_provider_id' => (int) $providerId,
        ]);

        return response()->json(['favorited' => true]);
    }

    /* =======================================================================
       دوال قديمة تُبقي التوافق ولتفادي الأخطاء إن استُدعيت دون قصد
       ======================================================================= */

    // إن تم استدعاء index نرجّع نفس صفحة المفضلة
    public function index()
    {
        return $this->page();
    }

    // نُرجع رسالة توضيحية لأن الإضافة تتم عبر toggle(providerId)
    public function AddToFavorite(Request $request, $service_id)
    {
        return response()->json(['error' => 'Use route: customer.favorites.toggle']);
    }

    // ليس لها استخدام هنا — نعيد payload فارغ
    public function Getfavoritelistservice()
    {
        return response()->json(['FavoriteList' => [], 'FavoriteQty' => 0]);
    }

    // الإزالة تتم أيضاً عبر toggle — نعيد نجاح شكلي
    public function RemoveFromFavorite(Request $request, $service_id)
    {
        return response()->json(['success' => true]);
    }
}
