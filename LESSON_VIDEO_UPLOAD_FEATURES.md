# Lesson Video Upload Features

## Overview
The lesson management system supports comprehensive video upload functionality, allowing administrators to upload videos for each lesson in a course. This includes both file uploads and URL-based videos.

## Current Implementation

### ✅ **Existing Features**

1. **Lesson Edit Interface** (`resources/js/pages/Admin/Lessons/Edit.vue`)
   - ✅ Video file upload (MP4, AVI, MOV, WMV, FLV, WEBM up to 100MB)
   - ✅ Video URL input (for external videos)
   - ✅ Thumbnail upload (JPEG, PNG, JPG, GIF up to 2MB)
   - ✅ Current video display with file information
   - ✅ Delete video functionality
   - ✅ Delete thumbnail functionality
   - ✅ AJAX upload handling

2. **Lesson Creation Interface** (`resources/js/pages/Admin/Lessons/Create.vue`)
   - ✅ New lesson creation form
   - ✅ Video upload fields
   - ✅ Thumbnail upload fields
   - ✅ Drag & drop interface
   - ✅ File validation

3. **Backend Controllers**
   - ✅ **VideoUploadController** - Handles lesson video uploads
   - ✅ **LessonController** - Updated with create/store methods
   - ✅ File validation and storage
   - ✅ AJAX upload endpoints

4. **Routes**
   ```php
   // Lesson management routes
   Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
   Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
   Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
   Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
   
   // Video upload routes
   Route::post('/lessons/{lesson}/upload-video', [VideoUploadController::class, 'upload'])->name('lessons.upload-video');
   Route::post('/lessons/{lesson}/upload-thumbnail', [VideoUploadController::class, 'uploadThumbnail'])->name('lessons.upload-thumbnail');
   Route::delete('/lessons/{lesson}/delete-video', [VideoUploadController::class, 'deleteVideo'])->name('lessons.delete-video');
   Route::delete('/lessons/{lesson}/delete-thumbnail', [VideoUploadController::class, 'deleteThumbnail'])->name('lessons.delete-thumbnail');
   ```

## How to Upload Videos for Lessons

### **Method 1: Create New Lesson with Video**
1. Navigate to Admin → Courses → Edit a course
2. Click "+ Add Lesson" button
3. Fill in lesson details (title, description, order)
4. Upload video file or enter video URL
5. Upload thumbnail (optional)
6. Click "Create Lesson"
7. You'll be redirected to the lesson edit page where you can upload video content

### **Method 2: Edit Existing Lesson**
1. Navigate to Admin → Courses → Edit a course
2. Click the edit icon next to any lesson
3. On the lesson edit page:
   - **Upload Video File**: Click "Choose Video File" or drag & drop
   - **Enter Video URL**: Alternatively, enter an external video URL
   - **Upload Thumbnail**: Click "Choose Image" for thumbnail
4. Files are uploaded immediately via AJAX
5. Click "Update Lesson" to save changes

### **Method 3: Direct Lesson Edit**
1. Navigate to Admin → Lessons → Edit (if you have the lesson ID)
2. Use the same interface as Method 2

## Video Upload Features

### **Supported File Types**
- **Videos**: MP4, AVI, MOV, WMV, FLV, WEBM
- **Images**: JPEG, PNG, JPG, GIF
- **Max Video Size**: 100MB
- **Max Image Size**: 2MB

### **Upload Methods**
1. **File Upload**: Direct file upload with drag & drop
2. **URL Input**: External video URLs (YouTube, Vimeo, etc.)
3. **AJAX Upload**: Real-time upload without page refresh

### **File Management**
- **Storage Location**: `storage/app/public/videos/` and `storage/app/public/thumbnails/`
- **File Naming**: Timestamp + random string for security
- **Original Names**: Preserved in database for display
- **Automatic Cleanup**: Old files deleted when replaced

## Database Schema

### **Lesson Table Fields**
```sql
video_url          VARCHAR - External video URL
video_file         VARCHAR - Stored video filename
video_filename     VARCHAR - Original video filename
video_mime_type    VARCHAR - Video MIME type
video_size         BIGINT - Video file size in bytes
video_duration     VARCHAR - Video duration (for future use)
thumbnail          VARCHAR - Thumbnail filename
```

## User Interface Features

### **Lesson Edit Page**
- ✅ Current video display with file info
- ✅ File size formatting
- ✅ Upload progress feedback
- ✅ Delete confirmation dialogs
- ✅ Error handling and validation

### **Lesson Create Page**
- ✅ Drag & drop file upload
- ✅ File type validation
- ✅ Order auto-calculation
- ✅ Course context display

### **Course Edit Page**
- ✅ Lesson list with edit links
- ✅ "Add Lesson" button (now functional)
- ✅ Free lesson indicators

## Security & Validation

### **Server-Side Validation**
- File type checking
- File size limits
- MIME type validation
- Admin-only access

### **Client-Side Validation**
- File type restrictions
- File size warnings
- Real-time feedback

### **Storage Security**
- Files stored outside web root
- Random filename generation
- Proper file permissions
- Access controlled through Laravel

## Video Playback

### **Uploaded Videos**
- Stored in `storage/app/public/videos/`
- Accessible via `/storage/videos/filename`
- Automatic URL generation in Lesson model

### **External Videos**
- URL-based videos (YouTube, Vimeo, etc.)
- No file storage required
- Direct URL playback

## Troubleshooting

### **Common Issues**
1. **Upload Fails**: Check file size and type restrictions
2. **Videos Not Playing**: Verify video format compatibility
3. **Permission Errors**: Ensure storage directories are writable
4. **AJAX Errors**: Check CSRF token and network connectivity

### **Debugging Steps**
1. Check browser console for JavaScript errors
2. Verify Laravel logs for upload errors
3. Test with smaller files first
4. Ensure storage link is created (`php artisan storage:link`)

## Future Enhancements

### **Planned Features**
1. **Video Processing**: Automatic compression and format conversion
2. **Thumbnail Generation**: Auto-create thumbnails from videos
3. **Video Streaming**: Optimized delivery for large files
4. **Progress Tracking**: Upload progress indicators
5. **Batch Upload**: Multiple file upload support

### **Technical Improvements**
1. **Chunked Uploads**: Support for very large files
2. **CDN Integration**: Cloud storage for better performance
3. **Video Transcoding**: Multiple format support
4. **Quality Settings**: Configurable video quality

## Summary

✅ **You can upload videos for each lesson** through multiple methods:
- Creating new lessons with video upload
- Editing existing lessons to add/change videos
- Using both file uploads and external URLs
- Uploading thumbnails for better presentation

The system is fully functional and ready for use! 