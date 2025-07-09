<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class providerCategoryController extends Controller
{
    public function index()
    {
        // لو الفئات عامة، نعرضها كلها
        $categories = Category::orderBy('id', 'desc')->paginate(20);

        // لو مزود الخدمة له فئات خاصة (مثلاً column provider_id)
        // $categories = Category::where('provider_id', auth()->id())->orderBy('id','desc')->paginate(20);

        return view('service_provider.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('service_provider.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // لو فئات خاصة لكل مزود: $data['provider_id'] = auth()->id();

        Category::create($request->only('name', 'description'));

        return redirect()
            ->route('provider.categories.index')
            ->with('msg', 'Category added successfully')
            ->with('type', 'success');
    }

    public function edit(Category $category)
    {
        return view('service_provider.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()
            ->route('provider.categories.index')
            ->with('msg', 'Category updated successfully')
            ->with('type', 'info');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('provider.categories.index')->with('success', 'Category deleted successfully.');
    }
}
