<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index(Request $request)
{
    $query = Service::with('serviceProvider');

    // بحث حسب نوع الخدمة
    if ($request->filled('serviceType')) {
        $query->where('serviceType', $request->serviceType);
    }

    // بحث حسب اسم مزود الخدمة
    if ($request->filled('provider_name')) {
        $query->whereHas('serviceProvider', function ($q) use ($request) {
            $q->where('username', 'like', '%' . $request->provider_name . '%');
        });
    }

    // بحث حسب السعر
    if ($request->filled('price')) {
        $query->where('price', $request->price);
    }

    $services = $query->orderBy('id', 'desc')->paginate(10);

    return view('admin.services.index', compact('services'));
}


    public function create()
    {
        // جلب كل المستخدمين الذين دورهم مزود خدمة
        $providers = User::where('role', 'service_provider')->get();
        return view('admin.services.create', compact('providers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'serviceType' => 'required|in:Electrical,Maintenance,Repairing,Cleaning,Washing',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'service_provider_id' => 'required|exists:users,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = date('YmdHi') . $image->getClientOriginalName();
        $image->move(public_path('upload/services'), $imageName);
        $imagePath = 'upload/services/' . $imageName;
    }

    Service::create([
        'name' => $request->name,
        'serviceType' => $request->serviceType,
        'description' => $request->description,
        'price' => $request->price,
        'service_provider_id' => $request->service_provider_id,
        'image' => $imagePath,
    ]);

    $notification = [
        'message' => 'Service Added successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('admin.services.index')->with($notification);
}



    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $providers = User::where('role', 'service_provider')->get();
        return view('admin.services.edit', compact('service', 'providers'));
    }

    public function update(Request $request, $id)
{
    $service = Service::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'serviceType' => 'required|in:Electrical,Maintenance,Repairing,Cleaning,Washing',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'service_provider_id' => 'required|exists:users,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $service->name = $request->name;
    $service->serviceType = $request->serviceType;
    $service->description = $request->description;
    $service->price = $request->price;
    $service->service_provider_id = $request->service_provider_id;

    if ($request->hasFile('image')) {
        // حذف الصورة القديمة
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $image = $request->file('image');
        $imageName = date('YmdHi') . $image->getClientOriginalName();
        $image->move(public_path('upload/services'), $imageName);
        $service->image = 'upload/services/' . $imageName;
    }

    $service->save();

    $notification = [
        'message' => 'Service updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('admin.services.index')->with($notification);
}


    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        $notification = [
        'message' => 'Service deleted successfully',
        'alert-type' => 'success'
    ];
        return redirect()
            ->route('admin.services.index')
            ->with($notification);

    }
}
