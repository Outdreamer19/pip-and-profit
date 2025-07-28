<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's purchased courses
        $purchasedCourses = $user->orders()
            ->where('status', 'completed')
            ->with(['course.lessons'])
            ->get()
            ->pluck('course');

        // Get user's recent orders
        $recentOrders = $user->orders()
            ->with('course')
            ->latest()
            ->take(5)
            ->get();

        // Get user's progress stats
        $stats = [
            'total_courses_purchased' => $purchasedCourses->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('amount'),
            'recent_activity' => $recentOrders->count(),
        ];

        return Inertia::render('Dashboard', [
            'purchasedCourses' => $purchasedCourses,
            'recentOrders' => $recentOrders,
            'stats' => $stats,
        ]);
    }
}
