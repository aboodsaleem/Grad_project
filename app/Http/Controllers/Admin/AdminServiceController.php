<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    // عرض كل الخدمات
    public function index()
    {
        $services = Service::with('serviceProvider')->orderBy('id', 'desc')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    // عرض نموذج تعديل الخدمة
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    // تحديث الخدمة
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            // ملاحظة: الأدمن ممكن ما يغير مزود الخدمة، إذا بدك تحطها في التحديث اعملها حسب الحاجة
            'image' => 'nullable|image',
        ]);

        $service->name = $request->name;
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

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    // حذف الخدمة
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
