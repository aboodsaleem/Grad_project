<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $services = Service::with(['category', 'provider'])->latest()->paginate(10);
        } elseif ($user->role == 'service_provider') {
            $services = Service::with(['category', 'provider'])
                ->where('provider_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $services = collect();
        }

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($req->hasFile('photo')) {
            $fn = hexdec(uniqid()) . '.' . $req->photo->extension();
            $req->photo->move(public_path('upload/services'), $fn);
            $data['photo'] = 'upload/services/' . $fn;
        }

        $data['provider_id'] = auth()->id();

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        $user = auth()->user();

        // تحقق إذا المزود يملك الخدمة أو الأدمن
        if ($user->role == 'service_provider' && $service->provider_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $req, Service $service)
    {
        $user = auth()->user();

        if ($user->role == 'service_provider' && $service->provider_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $req->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($req->hasFile('photo')) {
            if ($service->photo && file_exists(public_path($service->photo))) unlink(public_path($service->photo));
            $fn = hexdec(uniqid()) . '.' . $req->photo->extension();
            $req->photo->move(public_path('upload/services'), $fn);
            $data['photo'] = 'upload/services/' . $fn;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $user = auth()->user();

        if ($user->role == 'service_provider' && $service->provider_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($service->photo && file_exists(public_path($service->photo))) {
            unlink(public_path($service->photo));
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
