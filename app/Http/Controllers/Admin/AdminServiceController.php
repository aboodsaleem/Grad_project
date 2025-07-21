<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        // جلب كل الخدمات مع مزود الخدمة (User) المرتبط
        $services = Service::with('serviceProvider')->orderBy('id', 'desc')->paginate(10);
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'service_provider_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('upload/services/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $name_gen);
            $imagePath = 'upload/services/' . $name_gen;
        }

        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'service_provider_id' => $request->service_provider_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'تم إضافة الخدمة بنجاح');
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'service_provider_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('upload/services/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $name_gen);
            $service->image = 'upload/services/' . $name_gen;
        }

        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->service_provider_id = $request->service_provider_id;
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
