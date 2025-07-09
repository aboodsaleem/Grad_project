<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{
   public function index()
{
    // ✅ عرض جميع الخدمات بدون شرط على provider_id
    $services = Service::with(['category', 'provider'])
        ->latest()
        ->paginate(10);

    return view('service_provider.services.index', compact('services'));
}

    public function create()
    {
        $categories = Category::all();
        return view('service_provider.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('photo')) {
            $fn = hexdec(uniqid()) . '.' . $request->photo->extension();
            $request->photo->move(public_path('upload/services'), $fn);
            $data['photo'] = 'upload/services/' . $fn;
        }

        $data['provider_id'] = auth()->id(); // مزود الخدمة الحالي

        Service::create($data);

        return redirect()->route('provider.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        $user = auth()->user();

        if ($service->provider_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('service_provider.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $user = auth()->user();

        if ($service->provider_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('photo')) {
            if ($service->photo && file_exists(public_path($service->photo))) {
                unlink(public_path($service->photo));
            }
            $fn = hexdec(uniqid()) . '.' . $request->photo->extension();
            $request->photo->move(public_path('upload/services'), $fn);
            $data['photo'] = 'upload/services/' . $fn;
        }

        $service->update($data);

        return redirect()->route('provider.services.index')->with('success', 'Service updated.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $user = auth()->user();

        if ($service->provider_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($service->photo && file_exists(public_path($service->photo))) {
            unlink(public_path($service->photo));
        }

        $service->delete();

        return redirect()->route('provider.services.index')->with('success', 'Service deleted successfully.');
    }
}
