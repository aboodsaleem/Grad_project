<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // جلب كل الخدمات المفعّلة
        $services = Service::with('serviceProvider')->latest()->get();
        return view('frontend.index', compact('services'));
    }
}
