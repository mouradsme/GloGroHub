<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
class Marketplace extends Controller
{
    //
    public function index() {
        $Categories = Category::where('parent_id', 1)->get();
        $Products = Product::all();
        return view('marketplace.index', array('Categories' => $Categories, 'Products' => $Products));
    }

    public function getCategory($id) {
        $Categories = Category::where('parent_id', $id)->get();
        $Products = Product::where('category_id', $id)->get();

        return view('marketplace.index', array('Categories' => $Categories, 'Products' => $Products));
    }
}
