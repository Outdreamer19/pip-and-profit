<template>
  <AppLayout>
    <template #header>
      <Heading title="Edit Course" description="Update course information" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
          <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
            <!-- Course Title -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Course Title
              </label>
              <input
                v-model="form.title"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required
              />
              <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                {{ form.errors.title }}
              </p>
            </div>

            <!-- Course Description -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Description
              </label>
              <textarea
                v-model="form.description"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Describe what students will learn in this course..."
              ></textarea>
              <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                {{ form.errors.description }}
              </p>
            </div>

            <!-- Course Price -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Price ($)
              </label>
              <input
                v-model="form.price"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required
              />
              <p v-if="form.errors.price" class="mt-1 text-sm text-red-600">
                {{ form.errors.price }}
              </p>
            </div>

            <!-- Course Display Image -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Display Image
              </label>
              
              <!-- Current Image Display -->
              <div v-if="course.image" class="mb-4">
                <div class="flex items-center space-x-4">
                  <img 
                    :src="`/storage/course-images/${course.image}`" 
                    alt="Current course image"
                    class="w-20 h-20 object-cover rounded-lg border"
                  />
                  <div>
                    <p class="text-sm text-gray-600">Current image</p>
                    <button
                      type="button"
                      @click="deleteImage"
                      class="text-red-600 hover:text-red-800 text-sm"
                    >
                      Remove image
                    </button>
                  </div>
                </div>
              </div>

              <!-- Image Upload -->
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg
                    class="mx-auto h-12 w-12 text-gray-400"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 48 48"
                    aria-hidden="true"
                  >
                    <path
                      d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label
                      for="image-upload"
                      class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                    >
                      <span>Upload an image</span>
                      <input
                        id="image-upload"
                        ref="imageInput"
                        type="file"
                        accept="image/*"
                        class="sr-only"
                        @change="handleImageChange"
                      />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB (server limit: 2MB)</p>
                </div>
              </div>
              <div v-if="selectedImage" class="mt-2">
                <p class="text-sm text-gray-600">Selected: {{ selectedImage.name }}</p>
              </div>
              <p v-if="form.errors.image" class="mt-1 text-sm text-red-600">
                {{ form.errors.image }}
              </p>
            </div>

            <!-- Course Video -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Course Video (Optional)
              </label>
              
              <!-- Current Video Display -->
              <div v-if="course.video_file" class="mb-4">
                <div class="flex items-center space-x-4">
                  <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">{{ course.video_filename || 'Current video' }}</p>
                    <p class="text-xs text-gray-500">{{ formatFileSize(course.video_size) }}</p>
                    <button
                      type="button"
                      @click="deleteVideo"
                      class="text-red-600 hover:text-red-800 text-sm"
                    >
                      Remove video
                    </button>
                  </div>
                </div>
              </div>

              <!-- Video Upload -->
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg
                    class="mx-auto h-12 w-12 text-gray-400"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 48 48"
                    aria-hidden="true"
                  >
                    <path
                      d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label
                      for="video-upload"
                      class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                    >
                      <span>Upload a video</span>
                      <input
                        id="video-upload"
                        ref="videoInput"
                        type="file"
                        accept="video/*"
                        class="sr-only"
                        @change="handleVideoChange"
                      />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">MP4, AVI, MOV, WMV, FLV, WEBM up to 100MB (server limit: 2MB)</p>
                </div>
              </div>
              <div v-if="selectedVideo" class="mt-2">
                <p class="text-sm text-gray-600">Selected: {{ selectedVideo.name }}</p>
              </div>
              <p v-if="form.errors.video" class="mt-1 text-sm text-red-600">
                {{ form.errors.video }}
              </p>
            </div>

            <!-- Publish Status -->
            <div>
              <label class="flex items-center">
                <input
                  v-model="form.is_published"
                  type="checkbox"
                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
                <span class="ml-2 text-sm text-gray-700">Publish this course</span>
              </label>
            </div>

            <!-- Course Lessons -->
            <div>
              <h3 class="text-lg font-medium text-gray-900 mb-4">Course Lessons</h3>
              <div class="space-y-3">
                <div
                  v-for="(lesson, index) in course.lessons"
                  :key="lesson.id"
                  class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"
                >
                  <div class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-gray-500">{{ index + 1 }}</span>
                    <div>
                      <h4 class="font-medium text-gray-900">{{ lesson.title }}</h4>
                      <p class="text-sm text-gray-500">{{ lesson.description || 'No description' }}</p>
                    </div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <span
                      v-if="lesson.is_free"
                      class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                    >
                      Free
                    </span>
                    <Link
                      :href="route('admin.lessons.edit', lesson.id)"
                      class="text-indigo-600 hover:text-indigo-900 p-1"
                    >
                      <Icon name="edit" class="w-4 h-4" />
                    </Link>
                  </div>
                </div>
              </div>
              <Link
                :href="route('admin.lessons.create', course.slug)"
                class="mt-3 text-indigo-600 hover:text-indigo-900 text-sm font-medium inline-block"
              >
                + Add Lesson
              </Link>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <Link
                :href="route('admin.courses.index')"
                class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50"
              >
                Cancel
              </Link>
              
              <div class="flex space-x-3">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="form.processing">Updating...</span>
                  <span v-else>Update Course</span>
                </button>
                
                <Link
                  :href="route('courses.show', course.slug)"
                  class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700"
                >
                  View Course
                </Link>
                
                <Link
                  :href="route('admin.courses.index')"
                  class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700"
                >
                  All Courses
                </Link>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'
import { Link } from '@inertiajs/vue3'

interface Lesson {
  id: number
  title: string
  description: string | null
  is_free: boolean
}

interface Course {
  id: number
  title: string
  slug: string
  description: string | null
  price: number
  image: string | null
  video_file: string | null
  video_filename: string | null
  video_size: number | null
  is_published: boolean
  lessons: Lesson[]
}

interface Props {
  course: Course
}

const props = defineProps<Props>()

const form = useForm({
  title: props.course.title,
  description: props.course.description || '',
  price: parseFloat(props.course.price.toString()),
  image: null as File | null,
  video: null as File | null,
  is_published: props.course.is_published,
})

// Debug: Log initial form data
console.log('Initial form data:', {
  title: form.title,
  description: form.description,
  price: form.price,
  is_published: form.is_published,
  courseData: {
    title: props.course.title,
    price: props.course.price,
  }
})

const selectedImage = ref<File | null>(null)
const selectedVideo = ref<File | null>(null)
const imageInput = ref<HTMLInputElement>()
const videoInput = ref<HTMLInputElement>()

const handleImageChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedImage.value = target.files[0]
    form.image = target.files[0]
  }
}

const handleVideoChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedVideo.value = target.files[0]
    form.video = target.files[0]
  }
}

const formatFileSize = (bytes: number | null): string => {
  if (!bytes) return '0 B'
  const k = 1024
  const sizes = ['B', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const deleteImage = () => {
  if (confirm('Are you sure you want to remove the current image?')) {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    
    if (!csrfToken) {
      alert('CSRF token not found. Please refresh the page and try again.')
      return
    }
    
    console.log('Deleting image with CSRF token:', csrfToken)
    
    // Make AJAX call to delete image
    fetch(route('admin.courses.delete-image', props.course.slug), {
      method: 'DELETE',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json',
      },
    })
    .then(response => {
      console.log('Delete image response status:', response.status)
      return response.json()
    })
    .then((data: any) => {
      console.log('Delete image response data:', data)
      if (data.success) {
        alert('Image deleted successfully!')
        // Reload the page to show updated state
        window.location.reload()
      } else {
        alert('Error deleting image: ' + (data.message || 'Unknown error'))
      }
    })
    .catch(error => {
      console.error('Error deleting image:', error)
      alert('Error deleting image. Please try again.')
    })
  }
}

const deleteVideo = () => {
  if (confirm('Are you sure you want to remove the current video?')) {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    
    if (!csrfToken) {
      alert('CSRF token not found. Please refresh the page and try again.')
      return
    }
    
    console.log('Deleting video with CSRF token:', csrfToken)
    
    // Make AJAX call to delete video
    fetch(route('admin.courses.delete-video', props.course.slug), {
      method: 'DELETE',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json',
      },
    })
    .then(response => {
      console.log('Delete video response status:', response.status)
      return response.json()
    })
    .then((data: any) => {
      console.log('Delete video response data:', data)
      if (data.success) {
        alert('Video deleted successfully!')
        // Reload the page to show updated state
        window.location.reload()
      } else {
        alert('Error deleting video: ' + (data.message || 'Unknown error'))
      }
    })
    .catch(error => {
      console.error('Error deleting video:', error)
      alert('Error deleting video. Please try again.')
    })
  }
}

const submit = () => {
  // Explicitly set form data to ensure it's not empty
  form.title = form.title || props.course.title
  form.description = form.description || props.course.description || ''
  form.price = parseFloat(form.price.toString()) || parseFloat(props.course.price.toString())
  form.is_published = form.is_published
  
  console.log('Submitting form with data:', {
    title: form.title,
    description: form.description,
    price: form.price,
    priceType: typeof form.price,
    is_published: form.is_published,
    hasImage: !!form.image,
    hasVideo: !!form.video,
  })
  
  // Check if form data is valid before submitting
  if (!form.title || !form.price) {
    console.error('Form validation failed:', {
      title: form.title,
      price: form.price,
      titleEmpty: !form.title,
      priceEmpty: !form.price,
    })
    return
  }
  
  console.log('Final form data being sent:', {
    title: form.title,
    description: form.description,
    price: form.price,
    hasImage: !!form.image,
    hasVideo: !!form.video,
    is_published: form.is_published,
  })
  
  // Create FormData for traditional form submission
  const formData = new FormData()
  formData.append('title', form.title)
  formData.append('description', form.description)
  formData.append('price', form.price.toString())
  formData.append('is_published', form.is_published.toString())
  
  if (form.image) {
    formData.append('image', form.image)
  }
  if (form.video) {
    formData.append('video', form.video)
  }
  
  // Add CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
  if (csrfToken) {
    formData.append('_token', csrfToken)
  }
  formData.append('_method', 'PUT')
  
  // Use fetch API for traditional form submission
  fetch(route('admin.courses.update', props.course.slug), {
    method: 'POST', // Always POST for FormData with _method
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // Important for Pip & Profit to recognize AJAX
    },
  })
  .then(response => response.json())
  .then((data: any) => {
    console.log('Form submitted successfully:', data)
    if (data.success) {
      // Show success message
      alert(data.message || 'Course updated successfully!')
      // Reload the page to show updated data
      window.location.reload()
    } else {
      alert('Error updating course. Please try again.')
    }
  })
  .catch(error => {
    console.error('Form submission error:', error)
    if (error.response) {
      error.response.json().then((data: any) => {
        console.log('Validation errors:', data.errors)
        alert('Error updating course. Please check the form and try again.')
      })
    } else {
      alert('Error updating course. Please try again.')
    }
  })
}
</script> 