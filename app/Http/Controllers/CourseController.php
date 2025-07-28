<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->with('lessons')
            ->get();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Courses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
        ]);

        $courseData = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => (float) $validated['price'],
            'slug' => Str::slug($validated['title']),
            'is_published' => false,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFilename = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('course-images', $imageFilename, 'public');
            $courseData['image'] = $imageFilename;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoFilename = time() . '_' . Str::random(10) . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->storeAs('videos', $videoFilename, 'public');
            $courseData['video_file'] = $videoFilename;
            $courseData['video_filename'] = $videoFile->getClientOriginalName();
            $courseData['video_mime_type'] = $videoFile->getMimeType();
            $courseData['video_size'] = $videoFile->getSize();
        }

        $course = Course::create($courseData);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('lessons');
        
        // Check if admin is viewing in student mode
        $studentView = request()->query('studentView') === 'true';
        
        return Inertia::render('Courses/Show', [
            'course' => $course,
            'studentView' => $studentView,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        Log::info('CourseController::edit called', [
            'course_id' => $course->id,
            'course_slug' => $course->slug,
            'course_title' => $course->title,
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'request_url' => request()->url(),
            'request_method' => request()->method(),
        ]);

        // Check if user is admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            Log::warning('Non-admin user attempted to edit course', [
                'course_id' => $course->id,
                'course_slug' => $course->slug,
                'user_id' => Auth::id(),
                'user_email' => Auth::user()?->email,
            ]);
            abort(403);
        }

        $course->load('lessons');

        Log::info('CourseController::edit - course loaded with lessons', [
            'course_id' => $course->id,
            'course_slug' => $course->slug,
            'lessons_count' => $course->lessons->count(),
        ]);

        return Inertia::render('Admin/Courses/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        Log::info('CourseController::update called', [
            'course_id' => $course->id,
            'course_slug' => $course->slug,
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
        ]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'video' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
                'is_published' => 'nullable|in:true,false,0,1,on',
            ], [
                'image.max' => 'The image file size must not exceed 10MB. Please choose a smaller image.',
                'image.image' => 'The uploaded file must be a valid image (JPEG, PNG, JPG, GIF).',
                'video.max' => 'The video file size must not exceed 100MB. Please choose a smaller video.',
            ]);

            Log::info('CourseController::update - validation passed', [
                'validated_data' => $validated,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('CourseController::update - validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);
            
            // Check if the error is related to file upload size
            if (isset($e->errors()['image']) && str_contains(implode(' ', $e->errors()['image']), 'greater than')) {
                // Check PHP upload limits
                $uploadMaxFilesize = ini_get('upload_max_filesize');
                $postMaxSize = ini_get('post_max_size');
                
                Log::warning('CourseController::update - PHP upload limits detected', [
                    'upload_max_filesize' => $uploadMaxFilesize,
                    'post_max_size' => $postMaxSize,
                ]);
                
                // Add a helpful message about PHP limits
                $e->errors()['image'][] = "Note: Your server's PHP configuration limits uploads to {$uploadMaxFilesize}. Please contact your administrator to increase this limit or use a smaller image.";
            }
            
            throw $e;
        }

        $courseData = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => (float) $validated['price'],
            'slug' => Str::slug($validated['title']),
            'is_published' => in_array($validated['is_published'] ?? false, ['true', '1', 'on'], true),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image) {
                Storage::disk('public')->delete('course-images/' . $course->image);
            }
            
            $imageFile = $request->file('image');
            $imageFilename = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('course-images', $imageFilename, 'public');
            $courseData['image'] = $imageFilename;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($course->video_file) {
                Storage::disk('public')->delete('videos/' . $course->video_file);
            }
            
            $videoFile = $request->file('video');
            $videoFilename = time() . '_' . Str::random(10) . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->storeAs('videos', $videoFilename, 'public');
            $courseData['video_file'] = $videoFilename;
            $courseData['video_filename'] = $videoFile->getClientOriginalName();
            $courseData['video_mime_type'] = $videoFile->getMimeType();
            $courseData['video_size'] = $videoFile->getSize();
        }

        $course->update($courseData);

        Log::info('CourseController::update - course updated successfully', [
            'course_id' => $course->id,
            'course_slug' => $course->slug,
            'updated_data' => $courseData,
        ]);

        // Return JSON for AJAX requests, redirect for regular requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully.',
                'course' => $course->fresh()
            ]);
        }

        return back()->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Delete associated files
        if ($course->image) {
            Storage::disk('public')->delete('course-images/' . $course->image);
        }
        if ($course->video_file) {
            Storage::disk('public')->delete('videos/' . $course->video_file);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Delete course image
     */
    public function deleteImage(Course $course)
    {
        Log::info('CourseController::deleteImage called', [
            'course_id' => $course->id,
            'course_slug' => $course->slug,
            'current_image' => $course->image,
            'user_id' => Auth::id(),
        ]);

        if ($course->image) {
            // Delete the file from storage
            Storage::disk('public')->delete('course-images/' . $course->image);
            
            // Update the course to remove the image reference
            $course->update(['image' => null]);
            
            Log::info('CourseController::deleteImage - image deleted successfully', [
                'course_id' => $course->id,
                'deleted_image' => $course->image,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image to delete.',
        ], 404);
    }

    /**
     * Delete course video
     */
    public function deleteVideo(Course $course)
    {
        Log::info('CourseController::deleteVideo called', [
            'course_id' => $course->id,
            'course_slug' => $course->slug,
            'current_video' => $course->video_file,
            'user_id' => Auth::id(),
        ]);

        if ($course->video_file) {
            // Delete the file from storage
            Storage::disk('public')->delete('videos/' . $course->video_file);
            
            // Update the course to remove the video reference
            $course->update([
                'video_file' => null,
                'video_filename' => null,
                'video_mime_type' => null,
                'video_size' => null,
            ]);
            
            Log::info('CourseController::deleteVideo - video deleted successfully', [
                'course_id' => $course->id,
                'deleted_video' => $course->video_file,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video deleted successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No video to delete.',
        ], 404);
    }
}
