<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('service_provider_id', Auth::id())->get();
        return view('service_provider.services.index', compact('services'));
    }

    public function create()
    {
        return view('service_provider.services.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'serviceType' => 'required|in:Electrical,Maintenance,Repairing,Cleaning,Washing',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تحقق من الصورة (اختياري)
    ]);

    $data = $request->only(['name', 'serviceType', 'description', 'price']);
    $data['service_provider_id'] = Auth::id();

    // رفع الصورة إذا موجودة
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $uploadPath = public_path('upload/service_images/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $image->move($uploadPath, $name_gen);
        $data['image'] = 'upload/service_images/' . $name_gen;
    }

    Service::create($data);

    $notification = [
        'message' => 'Service Added successfully.',
        'alert-type' => 'success'
    ];

    return redirect()
        ->route('provider.dashboard')
        ->with($notification);
}


    public function edit(Service $service)
    {
        if ($service->service_provider_id !== Auth::id()) {
            abort(403);
        }

        return view('service_provider.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
{
    if ($service->service_provider_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'serviceType' => 'required|in:Electrical,Maintenance,Repairing,Cleaning,Washing',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'status' => 'nullable|boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تحقق من الصورة
    ]);

    $status = $request->has('status') ? 1 : 0;

    $data = $request->only(['name', 'serviceType', 'description', 'price']);
    $data['status'] = $status;

    // رفع صورة جديدة إذا موجودة وحذف القديمة
    if ($request->hasFile('image')) {
        // حذف الصورة القديمة إذا موجودة
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $uploadPath = public_path('upload/service_images/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $image->move($uploadPath, $name_gen);
        $data['image'] = 'upload/service_images/' . $name_gen;
    }

    $service->update($data);

    $notification = [
        'message' => 'Service updated successfully.',
        'alert-type' => 'success'
    ];

    return redirect()
        ->route('provider.dashboard')
        ->with($notification);
}



    public function destroy(Service $service)
    {
        if ($service->service_provider_id !== Auth::id()) {
            abort(403);
        }
        // حذف صورة الخدمة من السيرفر إذا موجودة
    if ($service->image && file_exists(public_path($service->image))) {
        unlink(public_path($service->image));
    }

        $service->delete();

    // ✅ إشعار النجاح
    $notification = [
        'message' => ' Service deleted successfully.  ',
        'alert-type' => 'success'
    ];

        return redirect()->route('provider.dashboard')->with($notification);
    }
}
