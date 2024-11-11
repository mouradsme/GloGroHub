<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    /**
     * Display a listing of holidays.
     */
    public function index()
    {
        $holidays = Holiday::with('category')->get();
        return view('holidays.index', compact('holidays'));
    }

    /**
     * Show the form for creating a new holiday.
     */
    public function create()
    {
        // Only allow users with role "site_manager" to access this
        if (Auth::user()->role !== 'site_manager') {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('holidays.create', compact('categories'));
    }

    /**
     * Store a newly created holiday in storage.
     */
    public function store(Request $request)
    {
        // Only allow users with role "site_manager" to add holidays
        if (Auth::user()->role !== 'site_manager') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
        ]);

        Holiday::create($request->all());

        return redirect()->route('holidays.index')->with('success', 'Holiday created successfully.');
    }
}
