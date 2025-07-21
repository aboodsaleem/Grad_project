<?php
namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProviderServiceController extends Controller
{
    // عرض كل الخدمات الخاصة بمزود الخدمة فقط (مستخدم مسجل بدور service_provider)
    public function index()
    {
        $providerId = Auth::id(); // هذا هو الـ user id اللي دوره service_provider
        $services = Service::where('service_provider_id', $providerId)->paginate(10);
        return view('provider.services.index', compact('services'));
    }

    // عرض نموذج إضافة خدمة جديدة
    public function create()
    {
        // ما في داعي تجيب مزودين لأن المزود الحالي هو المستخدم الحالي
        return view('provider.services.create');
    }

    // تخزين خدمة جديدة مرتبطة بالمستخدم الحالي كـ service_provider
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $serviceData = $request->only(['title', 'description', 'price']);
        $serviceData['service_provider_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/services'), $filename);
            $serviceData['image'] = 'uploads/services/' . $filename;
        }

        Service::create($serviceData);

        return redirect()->route('provider.services.index')->with('success', 'تم إضافة الخدمة بنجاح');
    }

    // عرض نموذج تعديل خدمة خاصة بالمزود الحالي فقط
    public function edit($id)
    {
        $providerId = Auth::id();
        $service = Service::where('id', $id)->where('service_provider_id', $providerId)->firstOrFail();

        return view('provider.services.edit', compact('service'));
    }

    // تحديث الخدمة الخاصة بالمزود الحالي فقط
    public function update(Request $request, $id)
    {
        $providerId = Auth::id();
        $service = Service::where('id', $id)->where('service_provider_id', $providerId)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;

        if ($request->hasFile('image')) {
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

    // حذف الخدمة الخاصة بالمزود الحالي فقط
    public function destroy($id)
    {
        $providerId = Auth::id();
        $service = Service::where('id', $id)->where('service_provider_id', $providerId)->firstOrFail();

        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('provider.services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
