<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
       $search = $request->input('search');
       $price = $request->input('maxPrice');
        $serviceType = $request->input('serviceType');


    $services = Service::with('serviceProvider')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {

                // إذا كانت نص (للاسم والوصف واسم المزود)
                $q->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('serviceProvider', function ($q2) use ($search) {
                      $q2->where('username', 'like', "%{$search}%");
                  });
            });
        })
        ->when($price, function ($query) use ($price) {
            $query->where('price', '<=', $price);
        })
        ->when($serviceType, function ($query) use ($serviceType) {
            $query->where('serviceType', $serviceType);
        })
        ->latest()
        ->get();

        $homeServices = Service::with('serviceProvider')->take(4)->get();
        return view('frontend.index', compact('services', 'homeServices'));
    }
}
