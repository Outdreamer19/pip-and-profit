<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PricingController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->with('lessons')
            ->get();

        return Inertia::render('Pricing', [
            'courses' => $courses,
        ]);
    }
}
