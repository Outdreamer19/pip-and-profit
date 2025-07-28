<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $course->load('lessons');

        return Inertia::render('Admin/Lessons/Create', [
            'course' => $course,
        ]);
    }

    public function store(Request $request, Course $course)
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

        $lesson = $course->lessons()->create([
            ...$validated,
            'is_free' => $validated['is_free'] ?? false,
        ]);

        return redirect()->route('admin.lessons.edit', $lesson)
            ->with('success', 'Lesson created successfully. You can now upload video content.');
    }

    public function show(Course $course, Lesson $lesson)
    {
        // Check if user has access to this course
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Allow admins to access any lesson for course content viewing
        if ($user->isAdmin()) {
            Log::info('Admin accessing lesson for course content viewing', [
                'lesson_id' => $lesson->id,
                'course_id' => $course->id,
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);
            
            $course->load('lessons');
            
            return Inertia::render('Lessons/View', [
                'lesson' => $lesson,
                'course' => $course,
            ]);
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
        Log::info('LessonController::edit called', [
            'lesson_id' => $lesson->id,
            'lesson_title' => $lesson->title,
            'course_id' => $lesson->course_id,
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'request_url' => request()->url(),
            'request_method' => request()->method(),
        ]);

        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            Log::warning('Non-admin user attempted to edit lesson', [
                'lesson_id' => $lesson->id,
                'user_id' => Auth::id(),
                'user_email' => Auth::user()?->email,
            ]);
            abort(403);
        }

        $lesson->load('course');

        Log::info('LessonController::edit - lesson loaded with course', [
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->course->id,
            'course_slug' => $lesson->course->slug,
            'course_title' => $lesson->course->title,
        ]);

        return Inertia::render('Admin/Lessons/Edit', [
            'lesson' => $lesson,
        ]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        Log::info('LessonController::update called', [
            'lesson_id' => $lesson->id,
            'lesson_title' => $lesson->title,
            'course_id' => $lesson->course_id,
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'request_url' => request()->url(),
            'request_method' => request()->method(),
            'request_data' => $request->all(),
        ]);

        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            Log::warning('Non-admin user attempted to update lesson', [
                'lesson_id' => $lesson->id,
                'user_id' => Auth::id(),
                'user_email' => Auth::user()?->email,
            ]);
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order' => 'required|integer|min:1',
            'is_free' => 'boolean',
        ]);

        Log::info('LessonController::update - validation passed', [
            'lesson_id' => $lesson->id,
            'validated_data' => $validated,
        ]);

        $lesson->update($validated);

        Log::info('LessonController::update - lesson updated successfully', [
            'lesson_id' => $lesson->id,
            'updated_data' => $lesson->fresh()->toArray(),
        ]);

        return redirect()->back()->with('success', 'Lesson updated successfully.');
    }
}
