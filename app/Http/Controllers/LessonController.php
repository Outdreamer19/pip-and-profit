<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        // Check if user has access to this course
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has purchased the course or if lesson is free
        $hasAccess = $lesson->is_free || $user->orders()
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->exists();
            
        if (!$hasAccess) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to purchase this course to access this lesson.');
        }
        
        $course->load('lessons');
        
        return Inertia::render('Lessons/View', [
            'lesson' => $lesson,
            'course' => $course,
        ]);
    }

    public function edit(Lesson $lesson)
    {
        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        return Inertia::render('Admin/Lessons/Edit', [
            'lesson' => $lesson,
        ]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order' => 'required|integer|min:1',
            'is_free' => 'boolean',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.courses.edit', $lesson->course_id)
            ->with('success', 'Lesson updated successfully.');
    }
}
