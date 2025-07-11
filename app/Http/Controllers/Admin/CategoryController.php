<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()
            ->route('admin.categories.index')
            ->with('msg', 'Category added successfully')
            ->with('type', 'success');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()
            ->route('admin.categories.index')
            ->with('msg', 'Category updated successfully')
            ->with('type', 'info');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // حذف صورة اذا موجودة (لو تستخدم صورة في التصنيف)
        // if ($category->photo && file_exists(public_path($category->photo))) {
        //     unlink(public_path($category->photo));
        // }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
