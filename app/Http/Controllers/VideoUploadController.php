<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoUploadController extends Controller
{
    /**
     * Upload a video file for a lesson
     */
    public function upload(Request $request, Lesson $lesson)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
        ]);

        $file = $request->file('video');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store the video file
        $path = $file->storeAs('videos', $filename, 'public');
        
        // Update the lesson with video information
        $lesson->update([
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
     * Upload a thumbnail for a lesson
     */
    public function uploadThumbnail(Request $request, Lesson $lesson)
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $file = $request->file('thumbnail');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store the thumbnail
        $path = $file->storeAs('thumbnails', $filename, 'public');
        
        // Update the lesson with thumbnail information
        $lesson->update([
            'thumbnail' => $filename,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thumbnail uploaded successfully',
            'filename' => $filename,
        ]);
    }

    /**
     * Delete a video file
     */
    public function deleteVideo(Lesson $lesson)
    {
        if ($lesson->video_file) {
            // Delete the file from storage
            Storage::disk('public')->delete('videos/' . $lesson->video_file);
            
            // Clear the video fields
            $lesson->update([
                'video_file' => null,
                'video_filename' => null,
                'video_mime_type' => null,
                'video_size' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Video deleted successfully',
        ]);
    }

    /**
     * Delete a thumbnail
     */
    public function deleteThumbnail(Lesson $lesson)
    {
        if ($lesson->thumbnail) {
            // Delete the file from storage
            Storage::disk('public')->delete('thumbnails/' . $lesson->thumbnail);
            
            // Clear the thumbnail field
            $lesson->update([
                'thumbnail' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thumbnail deleted successfully',
        ]);
    }
}
