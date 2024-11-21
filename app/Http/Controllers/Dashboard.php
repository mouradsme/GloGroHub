<?php

namespace App\Http\Controllers;
use App\Charts\AdminRetailers;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    //
    public function users_index()
    {
        $users = User::all(); // Fetch all users
        return view('users.index', compact('users')); // Pass users to the view
    }

    public function users_destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }


    public function admin_dashboard() {
        $chart = new AdminRetailers;
        $chart->labels(['2 days ago', 'Yesterday', 'Today']);
        $chart->dataset('My dataset', 'bar', [10, 15, 30]);
        return view('site_manager.dashboard', compact('chart'));
    }


    public function retailer_dashboard() {
        return view('retailer.dashboard');
    }

    public function wholesaler_dashboard() {
        return view('wholesaler.dashboard');
    }  

    public function index() {
        $user_role = auth()->user()->role;
        switch ($user_role) {
            case 'site_manager':
                return $this->admin_dashboard();
            case 'retailer':
                return $this->retailer_dashboard();
            case 'wholesaler':
                return $this->wholesaler_dashboard();
            default:
                return abort(403, 'Unauthorized');
        }
    }

    public function add_user() {
        $user_role = auth()->user()->role;
        if ($user_role == 'site_manager') {
            return view('users.create');
        }
        return abort('403');
    }

    public function add_category() {
        $user_role = auth()->user()->role;
        $categories = Category::all();
        if ($user_role == 'site_manager') {
            return view('categories.create', compact('categories'));
        }
        return abort('403');

    }

    
}
