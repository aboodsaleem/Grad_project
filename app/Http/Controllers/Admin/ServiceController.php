<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    // عرض الخدمات حسب دور المستخدم
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            // الأدمن يشوف كل الخدمات
            $services = Service::orderBy('id', 'desc')->paginate(10);
        } elseif ($user->role == 'service_provider') {
            // مزود الخدمة يشوف خدماته فقط
            $serviceProvider = ServiceProvider::where('user_id', $user->id)->first();
            if ($serviceProvider) {
                $services = Service::where('service_provider_id', $serviceProvider->id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            } else {
                $services = collect(); // مجموعة فارغة
            }
        } else {
            // العميل يشوف الخدمات المتوفرة فقط (مثلا الحالة approved)
            $services = Service::where('status', 'approved')->orderBy('id', 'desc')->paginate(10);
        }

        return view('services.index', compact('services'));
    }

    // صفحة إنشاء خدمة جديدة (لمزود الخدمة أو الأدمن)
    public function create()
    {
        return view('services.create');
    }

    // حفظ خدمة جديدة
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:pending,approved,rejected', // الأدمن يمكنه التحكم بالحالة
        ]);

        $service = new Service();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;

        // حدد مزود الخدمة حسب الدور
        if ($user->role == 'service_provider') {
            $serviceProvider = ServiceProvider::where('user_id', $user->id)->first();
            if (!$serviceProvider) {
                return redirect()->back()->with('error', 'مزود الخدمة غير موجود');
            }
            $service->service_provider_id = $serviceProvider->id;
            $service->status = 'pending'; // مزود الخدمة لا يقرر حالة الخدمة
        } elseif ($user->role == 'admin') {
            // إذا الأدمن يحدد مزود الخدمة وحالة الخدمة
            $service->service_provider_id = $request->service_provider_id ?? null;
            $service->status = $request->status ?? 'approved';
        }

        // رفع الصورة إذا موجودة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/services/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $name_gen);

            $service->image = 'uploads/services/' . $name_gen;
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'تم إضافة الخدمة بنجاح');
    }

    // عرض تفاصيل الخدمة
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    // صفحة تعديل الخدمة (لمزود الخدمة أو الأدمن)
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        // تحقق من الصلاحيات: الأدمن يشوف كل الخدمات، مزود الخدمة يشوف خدماته فقط
        $user = Auth::user();
        if ($user->role == 'service_provider') {
            $serviceProvider = ServiceProvider::where('user_id', $user->id)->first();
            if ($service->service_provider_id != $serviceProvider->id) {
                abort(403, 'ليس لديك صلاحية تعديل هذه الخدمة');
            }
        }

        return view('services.edit', compact('service'));
    }

    // تحديث الخدمة
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $user = Auth::user();
        if ($user->role == 'service_provider') {
            $serviceProvider = ServiceProvider::where('user_id', $user->id)->first();
            if ($service->service_provider_id != $serviceProvider->id) {
                abort(403, 'ليس لديك صلاحية تعديل هذه الخدمة');
            }
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;

        // الأدمن فقط يمكنه تعديل الحالة
        if ($user->role == 'admin' && $request->has('status')) {
            $service->status = $request->status;
        }

        // رفع صورة جديدة إذا أرسلت، وحذف القديمة
        if ($request->hasFile('image')) {
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/services/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $name_gen);

            $service->image = 'uploads/services/' . $name_gen;
        }

        $service->save();

        return redirect()->route('services.index')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    // حذف الخدمة
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $user = Auth::user();
        if ($user->role == 'service_provider') {
            $serviceProvider = ServiceProvider::where('user_id', $user->id)->first();
            if ($service->service_provider_id != $serviceProvider->id) {
                abort(403, 'ليس لديك صلاحية حذف هذه الخدمة');
            }
        }

        // حذف الصورة من المجلد إذا موجودة
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
