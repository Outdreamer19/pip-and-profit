# Course Video Upload Features

## Overview
The course management system now supports video uploads for courses, allowing administrators to upload both display images and video files when creating or editing courses.

## New Features

### 1. Video Upload for Courses
- **File Types Supported**: MP4, AVI, MOV, WMV, FLV, WEBM
- **Maximum File Size**: 100MB
- **Storage Location**: `storage/app/public/videos/`

### 2. Image Upload for Courses
- **File Types Supported**: JPEG, PNG, JPG, GIF
- **Maximum File Size**: 2MB
- **Storage Location**: `storage/app/public/course-images/`

## Database Changes

### New Fields Added to Courses Table
- `video_file` - The stored filename of the uploaded video
- `video_filename` - The original filename of the uploaded video
- `video_mime_type` - The MIME type of the video file
- `video_size` - The size of the video file in bytes
- `video_duration` - The duration of the video (for future use)

## Backend Implementation

### Controllers
1. **CourseController** - Updated to handle file uploads in `store()` and `update()` methods
2. **CourseVideoUploadController** - New controller for handling AJAX video/image uploads

### Routes Added
```php
// Course video upload routes
Route::post('/courses/{course}/upload-video', [CourseVideoUploadController::class, 'upload'])->name('courses.upload-video');
Route::post('/courses/{course}/upload-image', [CourseVideoUploadController::class, 'uploadImage'])->name('courses.upload-image');
Route::delete('/courses/{course}/delete-video', [CourseVideoUploadController::class, 'deleteVideo'])->name('courses.delete-video');
Route::delete('/courses/{course}/delete-image', [CourseVideoUploadController::class, 'deleteImage'])->name('courses.delete-image');
```

### Model Updates
- **Course Model** - Added video fields to `$fillable` array and `$casts`
- Added `getVideoUrlAttribute()` method to generate video URLs

## Frontend Implementation

### Updated Forms
1. **Course Create Form** (`resources/js/pages/Admin/Courses/Create.vue`)
   - Added file upload fields for both image and video
   - Drag and drop interface
   - File type validation
   - File size display

2. **Course Edit Form** (`resources/js/pages/Admin/Courses/Edit.vue`)
   - Shows current uploaded files
   - Allows replacement of existing files
   - File size formatting
   - Remove file functionality

### Features
- **Drag and Drop**: Users can drag files directly onto the upload areas
- **File Validation**: Client-side validation for file types and sizes
- **Progress Feedback**: Shows selected file names
- **Current File Display**: Shows existing files with options to remove them

## Usage

### Creating a New Course
1. Navigate to Admin → Courses → Create
2. Fill in basic course information (title, description, price)
3. Upload a display image (optional)
4. Upload a course video (optional)
5. Set publish status
6. Click "Create Course"

### Editing an Existing Course
1. Navigate to Admin → Courses → Edit
2. Modify course information as needed
3. Replace or remove existing images/videos
4. Upload new files if needed
5. Click "Update Course"

## File Management

### Storage Structure
```
storage/app/public/
├── videos/           # Course and lesson videos
├── course-images/    # Course display images
└── thumbnails/       # Lesson thumbnails
```

### File Naming
- Files are renamed with timestamp and random string for security
- Original filenames are preserved in the database
- Files are stored in organized directories by type

### Cleanup
- Old files are automatically deleted when replaced
- Files are cleaned up when courses are deleted
- Storage links are properly configured for public access

## Security Features

### File Validation
- Server-side validation of file types and sizes
- Client-side validation for better UX
- MIME type checking
- File size limits enforced

### Storage Security
- Files stored outside web root
- Random filename generation
- Proper file permissions
- Access controlled through Laravel's storage system

## Future Enhancements

### Planned Features
1. **Video Processing**: Automatic video compression and format conversion
2. **Thumbnail Generation**: Automatic thumbnail creation from videos
3. **Video Streaming**: Optimized video delivery
4. **Duration Detection**: Automatic video duration detection
5. **Progress Tracking**: Upload progress indicators

### Technical Improvements
1. **Chunked Uploads**: Support for large file uploads
2. **CDN Integration**: Cloud storage integration
3. **Video Transcoding**: Multiple format support
4. **Quality Settings**: Configurable video quality options

## Troubleshooting

### Common Issues
1. **File Upload Fails**: Check file size and type restrictions
2. **Images Not Displaying**: Verify storage link is created (`php artisan storage:link`)
3. **Videos Not Playing**: Check video format compatibility
4. **Permission Errors**: Ensure storage directories are writable

### Debugging
- Check Laravel logs for upload errors
- Verify file permissions on storage directories
- Test with smaller files first
- Check browser console for JavaScript errors 