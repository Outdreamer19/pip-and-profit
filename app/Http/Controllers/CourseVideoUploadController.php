<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseVideoUploadController extends Controller
{
    /**
     * Upload a video file for a course
     */
    public function upload(Request $request, Course $course)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
        ]);

        $file = $request->file('video');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store the video file
        $path = $file->storeAs('videos', $filename, 'public');
        
        // Update the course with video information
        $course->update([
            'video_file' => $filename,
            'video_filename' => $file->getClientOriginalName(),
            'video_mime_type' => $file->getMimeType(),
            'video_size' => $file->getSize(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded successfully',
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Upload a display image for a course
     */
    public function uploadImage(Request $request, Course $course)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store the image
        $path = $file->storeAs('course-images', $filename, 'public');
        
        // Update the course with image information
        $course->update([
            'image' => $filename,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'filename' => $filename,
        ]);
    }

    /**
     * Delete a video file
     */
    public function deleteVideo(Course $course)
    {
        if ($course->video_file) {
            // Delete the file from storage
            Storage::disk('public')->delete('videos/' . $course->video_file);
            
            // Clear the video fields
            $course->update([
                'video_file' => null,
                'video_filename' => null,
                'video_mime_type' => null,
                'video_size' => null,
                'video_duration' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Video deleted successfully',
        ]);
    }

    /**
     * Delete a display image
     */
    public function deleteImage(Course $course)
    {
        if ($course->image) {
            // Delete the file from storage
            Storage::disk('public')->delete('course-images/' . $course->image);
            
            // Clear the image field
            $course->update([
                'image' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully',
        ]);
    }
}
