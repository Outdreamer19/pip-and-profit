<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoUploadController extends Controller
{
    /**
     * Upload a video file for a lesson
     */
    public function upload(Request $request, Lesson $lesson)
    {
        Log::info('VideoUploadController::upload called', [
            'lesson_id' => $lesson->id,
            'lesson_title' => $lesson->title,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'request_url' => request()->url(),
            'request_method' => request()->method(),
            'has_file' => $request->hasFile('video'),
            'file_size' => $request->file('video')?->getSize(),
            'file_name' => $request->file('video')?->getClientOriginalName(),
        ]);

        try {
            $request->validate([
                'video' => 'required|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
            ]);

            $file = $request->file('video');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            Log::info('VideoUploadController::upload - file validation passed', [
                'lesson_id' => $lesson->id,
                'original_filename' => $file->getClientOriginalName(),
                'generated_filename' => $filename,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);
            
            // Store the video file
            $path = $file->storeAs('videos', $filename, 'public');
            
            Log::info('VideoUploadController::upload - file stored', [
                'lesson_id' => $lesson->id,
                'storage_path' => $path,
                'public_url' => asset('storage/videos/' . $filename),
            ]);
            
            // Update the lesson with video information
            $lesson->update([
                'video_file' => $filename,
                'video_filename' => $file->getClientOriginalName(),
                'video_mime_type' => $file->getMimeType(),
                'video_size' => $file->getSize(),
            ]);

            Log::info('VideoUploadController::upload - lesson updated with video info', [
                'lesson_id' => $lesson->id,
                'video_file' => $filename,
                'video_filename' => $file->getClientOriginalName(),
                'video_size' => $file->getSize(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('VideoUploadController::upload - validation failed', [
                'lesson_id' => $lesson->id,
                'errors' => $e->errors(),
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('VideoUploadController::upload - exception occurred', [
                'lesson_id' => $lesson->id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the video',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload a thumbnail for a lesson
     */
    public function uploadThumbnail(Request $request, Lesson $lesson)
    {
        Log::info('VideoUploadController::uploadThumbnail called', [
            'lesson_id' => $lesson->id,
            'lesson_title' => $lesson->title,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'request_url' => request()->url(),
            'request_method' => request()->method(),
            'has_file' => $request->hasFile('thumbnail'),
            'file_size' => $request->file('thumbnail')?->getSize(),
            'file_name' => $request->file('thumbnail')?->getClientOriginalName(),
        ]);

        try {
            $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            ]);

            $file = $request->file('thumbnail');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            Log::info('VideoUploadController::uploadThumbnail - file validation passed', [
                'lesson_id' => $lesson->id,
                'original_filename' => $file->getClientOriginalName(),
                'generated_filename' => $filename,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);
            
            // Store the thumbnail
            $path = $file->storeAs('thumbnails', $filename, 'public');
            
            Log::info('VideoUploadController::uploadThumbnail - file stored', [
                'lesson_id' => $lesson->id,
                'storage_path' => $path,
                'public_url' => asset('storage/thumbnails/' . $filename),
            ]);
            
            // Update the lesson with thumbnail information
            $lesson->update([
                'thumbnail' => $filename,
            ]);

            Log::info('VideoUploadController::uploadThumbnail - lesson updated with thumbnail info', [
                'lesson_id' => $lesson->id,
                'thumbnail' => $filename,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thumbnail uploaded successfully',
                'filename' => $filename,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('VideoUploadController::uploadThumbnail - validation failed', [
                'lesson_id' => $lesson->id,
                'errors' => $e->errors(),
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('VideoUploadController::uploadThumbnail - exception occurred', [
                'lesson_id' => $lesson->id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the thumbnail',
                'error' => $e->getMessage(),
            ], 500);
        }
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
