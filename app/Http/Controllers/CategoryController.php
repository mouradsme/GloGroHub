<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Optionally, include parent and children relationships
        $categories = Category::with(['parent', 'children'])->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Prevent circular reference by ensuring parent_id is not the same as the new category's id
        // Not necessary during creation as the id is not yet set

        $category = Category::create([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($category->exists) {
            return view('site_manager.dashboard');
        }

        return view('site_manager.add-category');
    }

    /**
     * Display the specified category along with its products and children.
     */
    public function show($id)
    {
        $category = Category::with(['products', 'children'])->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
        ]);

        // Prevent circular reference by ensuring the parent is not a child of the current category
        if ($request->parent_id) {
            $parent = Category::find($request->parent_id);
            if ($this->isCircularReference($category, $parent)) {
                return response()->json(['message' => 'Invalid parent category (circular reference)'], 400);
            }
        }

        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Optionally, handle reassigning or deleting child categories
        // Here, child categories are deleted due to 'cascade' on the foreign key

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    /**
     * Check for circular references to prevent a category from being its own ancestor.
     *
     * @param  Category  $category
     * @param  Category|null  $parent
     * @return bool
     */
    private function isCircularReference(Category $category, $parent)
    {
        if (!$parent) {
            return false;
        }

        if ($parent->id === $category->id) {
            return true;
        }

        return $this->isCircularReference($category, $parent->parent);
    }
}
