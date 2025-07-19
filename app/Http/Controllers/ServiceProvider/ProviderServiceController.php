<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderServiceController extends Controller
{
    // عرض كل الخدمات الخاصة بمزود الخدمة فقط
    public function index()
    {
        $providerId = Auth::id();
        $services = Service::where('service_provider_id', $providerId)->paginate(10);
        return view('provider.services.index', compact('services'));
    }

    // نموذج إضافة خدمة جديدة
    public function create()
    {
        return view('provider.services.create');
    }

    // تخزين خدمة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            // غيرها من القواعد حسب الحاجة
        ]);

        $serviceData = $request->only(['name', 'description', 'price']);
        $serviceData['service_provider_id'] = Auth::id();

        // معالجة رفع الصورة إذا موجودة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/services'), $filename);
            $serviceData['image'] = 'uploads/services/' . $filename;
        }

        Service::create($serviceData);

        return redirect()->route('provider.services.index')->with('success', 'تم إضافة الخدمة بنجاح');
    }

    // نموذج تعديل الخدمة
    public function edit($id)
    {
        $providerId = Auth::id();
        $service = Service::where('id', $id)->where('service_provider_id', $providerId)->firstOrFail();

        return view('provider.services.edit', compact('service'));
    }

    // تحديث الخدمة
    public function update(Request $request, $id)
    {
        $providerId = Auth::id();
        $service = Service::where('id', $id)->where('service_provider_id', $providerId)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/services'), $filename);
            $service->image = 'uploads/services/' . $filename;
        }

        $service->save();

        return redirect()->route('provider.services.index')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    // حذف الخدمة
    public function destroy($id)
    {
        $providerId = Auth::id();
        $service = Service::where('id', $id)->where('service_provider_id', $providerId)->firstOrFail();

        // حذف الصورة من السيرفر
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('provider.services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
