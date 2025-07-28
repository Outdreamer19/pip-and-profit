# Admin Course Management Guide

## How to Access Course Management as Admin

### **Step 1: Login as Admin**
1. Go to `http://127.0.0.1:8000/login`
2. Login with admin credentials:
   - **Email**: `admin@pipandprofit.com`
   - **Password**: (check your seeder or use a known password)

### **Step 2: Access Admin Dashboard**
After logging in as admin, you'll see additional admin navigation items in the sidebar:
- **Admin Dashboard** - Overview of system stats
- **Manage Courses** - View and manage all courses
- **User Management** - Manage users
- **Orders & Payments** - View orders and payments

### **Step 3: View All Courses**
1. Click **"Manage Courses"** in the admin sidebar
2. Or go directly to: `http://127.0.0.1:8000/admin/courses`
3. You'll see a list of all courses with options to:
   - **Edit** - Modify course details
   - **View** - See the course as a student would
   - **Delete** - Remove the course

### **Step 4: Create New Course**
1. Click **"Add Course"** button on the courses page
2. Or go to: `http://127.0.0.1:8000/admin/courses/create`
3. Fill in course details and upload images/videos
4. Click **"Create Course"**

### **Step 5: Edit Existing Course**
1. Click **"Edit"** button next to any course
2. Or go to: `http://127.0.0.1:8000/admin/courses/{slug}/edit`
3. Modify course details, upload new files
4. Click **"Update Course"**

### **Step 6: View Course as Student**
1. Click **"View Course"** button on any course
2. Or go to: `http://127.0.0.1:8000/courses/{slug}`
3. This shows how students see the course

## Course Management Features

### **✅ Available Actions:**
- **Create Courses** - Add new courses with video/image uploads
- **Edit Courses** - Modify existing courses
- **View Courses** - See courses as students do
- **Delete Courses** - Remove courses (with confirmation)
- **Publish/Unpublish** - Control course visibility
- **Manage Lessons** - Add/edit lessons for each course

### **✅ Course Information Displayed:**
- Course title and description
- Publication status (Published/Draft)
- Number of lessons
- Price
- Course image (if uploaded)
- Creation date

### **✅ Navigation Options:**
- **Admin Dashboard** - System overview
- **Manage Courses** - Course listing
- **Add Course** - Create new course
- **Edit Course** - Modify existing course
- **View Course** - Preview as student
- **All Courses** - Back to course listing

## Troubleshooting

### **If you can't see admin options:**
1. Make sure you're logged in as an admin user
2. Check that your user has `role = 'admin'` in the database
3. Clear browser cache and refresh

### **If courses don't appear:**
1. Check that courses exist in the database
2. Verify you're on the correct admin page
3. Check browser console for JavaScript errors

### **If you can't access admin pages:**
1. Ensure you're authenticated
2. Check that your user has admin privileges
3. Try logging out and back in

## Quick Access URLs

- **Admin Dashboard**: `http://127.0.0.1:8000/admin`
- **Manage Courses**: `http://127.0.0.1:8000/admin/courses`
- **Create Course**: `http://127.0.0.1:8000/admin/courses/create`
- **Edit Course**: `http://127.0.0.1:8000/admin/courses/{slug}/edit`
- **View Course**: `http://127.0.0.1:8000/courses/{slug}`

## Current Courses in System

Based on the database, you have these courses:
1. **Forex Trading Mastery** (Published)
2. **Volatility Trading Strategies** (Published)  
3. **Advanced Trading Techniques** (Published)
4. **Test Course** (Draft)

All courses should be visible in the admin course management interface once you're logged in as admin. 