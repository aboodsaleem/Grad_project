<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    // عرض جميع الخدمات المتاحة (مفعلة فقط مثلاً)
    public function index()
    {
        // نعرض الخدمات المتاحة فقط
        $services = Service::where('status', 'active')->orderBy('id', 'desc')->paginate(10);
        return view('customer.services.index', compact('services'));
    }

    // عرض تفاصيل خدمة واحدة
    public function show($id)
    {
        $service = Service::where('status', 'active')->findOrFail($id);
        return view('customer.services.show', compact('service'));
    }
}
