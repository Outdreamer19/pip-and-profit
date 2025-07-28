<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('amount'),
        ];

        $recent_orders = Order::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        $recent_courses = Course::with('lessons')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'recent_courses' => $recent_courses,
        ]);
    }

    public function courses()
    {
        $courses = Course::with('lessons')
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function users()
    {
        $users = User::with('orders')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function orders()
    {
        $orders = Order::with(['user', 'course'])
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
        ]);
    }
}
