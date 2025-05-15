<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $category = Category::findOrFail($id);

        // Pastikan hanya user yang punya kategori bisa lihat
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        // Pastikan hanya user yang punya kategori bisa edit
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
         if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
