<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;

class Marketplace extends Controller
{
    //
    private function getSubCategories($categoryId) {
        $categoryIds = collect([$categoryId]);
        $subcategories = Category::where('parent_id', $categoryId)->get();
        return $subcategories;
    }

    private function getAllCategoryIds($categoryId) {
        $categoryIds = collect([$categoryId]);
        $subcategories = Category::where('parent_id', $categoryId)->get();

        foreach ($subcategories as $subcategory) {
            $categoryIds = $categoryIds->merge($this->getAllCategoryIds($subcategory->id));
        }

        return $categoryIds;
    }

    private function getCategoriesBreadcrumbs($seedCategoryId) {
        $breadcrumbs = [];
        $id = $seedCategoryId;
        while ($id) {
            $category = Category::find($id);

            if (!$category) {
                break;
            }

            $breadcrumbs[] = $category; // Add category to breadcrumbs
            $id = $category->parent_id; // Move to the parent category
        }

        // Reverse the breadcrumbs to get the order from root to current
        return array_reverse($breadcrumbs);
    }

    public function index() {
        $Categories = $this->getSubCategories(1);
        $Products = Product::paginate(10); // Paginate with 10 items per page
        $Suppliers = Supplier::all();
        return view('marketplace.index', array(
            'Categories' => $Categories,
            'Products' => $Products,
            'Suppliers' => $Suppliers
        ));
    }

    public function getCategory($id) {
        $categoryIds = $this->getAllCategoryIds($id);
        $Categories = $this->getCategoriesBreadcrumbs($id);
        $SubCategories = $this->getSubCategories($id);

        $Products = Product::whereIn('category_id', $categoryIds)->paginate(10); // Paginate with 10 items per page
        $Suppliers = Supplier::all();

        return view('marketplace.index', array(
            'Categories' => $Categories,
            'Products' => $Products,
            'Suppliers' => $Suppliers,
            'SubCategories' => $SubCategories
        ));
    }
}
