<template>
  <AppLayout>
    <template #header>
      <Heading title="Edit Lesson" description="Update lesson information and upload video content" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
          <form @submit.prevent="submit" class="space-y-6">
            <!-- Lesson Title -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Lesson Title
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

            <!-- Lesson Description -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Description
              </label>
              <textarea
                v-model="form.description"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Describe what this lesson covers..."
              ></textarea>
              <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                {{ form.errors.description }}
              </p>
            </div>

            <!-- Lesson Order -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Order
              </label>
              <input
                v-model="form.order"
                type="number"
                min="1"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                required
              />
              <p v-if="form.errors.order" class="mt-1 text-sm text-red-600">
                {{ form.errors.order }}
              </p>
            </div>

            <!-- Free Lesson Toggle -->
            <div>
              <label class="flex items-center">
                <input
                  v-model="form.is_free"
                  type="checkbox"
                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
                <span class="ml-2 text-sm text-gray-700">This is a free lesson</span>
              </label>
            </div>

            <!-- Video Upload Section -->
            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Video Content</h3>
              
              <!-- Current Video Display -->
              <div v-if="lesson.video_file || lesson.video_url" class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-2">Current Video</h4>
                <div class="flex items-center space-x-4">
                  <div class="flex-1">
                    <p class="text-sm text-gray-600">
                      <span v-if="lesson.video_file">File: {{ lesson.video_filename }}</span>
                      <span v-else>URL: {{ lesson.video_url }}</span>
                    </p>
                    <p v-if="lesson.video_size" class="text-xs text-gray-500">
                      Size: {{ formatFileSize(lesson.video_size) }}
                    </p>
                  </div>
                  <button
                    type="button"
                    @click="deleteVideo"
                    class="text-red-600 hover:text-red-900 text-sm font-medium"
                  >
                    Delete Video
                  </button>
                </div>
              </div>

              <!-- Video Upload -->
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Video File
                  </label>
                  <div class="flex items-center space-x-4">
                    <input
                      ref="videoInput"
                      type="file"
                      accept="video/*"
                      @change="handleVideoUpload"
                      class="hidden"
                    />
                    <button
                      type="button"
                      @click="() => videoInput.value?.click()"
                      class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700"
                    >
                      Choose Video File
                    </button>
                    <span v-if="videoFile" class="text-sm text-gray-600">
                      {{ videoFile.name }}
                    </span>
                  </div>
                  <p class="text-xs text-gray-500 mt-1">
                    Supported formats: MP4, AVI, MOV, WMV, FLV, WebM (Max 100MB)
                  </p>
                </div>

                <!-- Video URL (Alternative) -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Or Enter Video URL
                  </label>
                  <input
                    v-model="form.video_url"
                    type="url"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="https://example.com/video.mp4"
                  />
                  <p v-if="form.errors.video_url" class="mt-1 text-sm text-red-600">
                    {{ form.errors.video_url }}
                  </p>
                </div>
              </div>
            </div>

            <!-- Thumbnail Upload Section -->
            <div class="border-t border-gray-200 pt-6">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Thumbnail</h3>
              
              <!-- Current Thumbnail -->
              <div v-if="lesson.thumbnail" class="mb-4">
                <h4 class="font-medium text-gray-900 mb-2">Current Thumbnail</h4>
                <div class="flex items-center space-x-4">
                  <img
                    :src="lesson.thumbnail_url"
                    alt="Lesson thumbnail"
                    class="w-32 h-20 object-cover rounded-lg"
                  />
                  <button
                    type="button"
                    @click="deleteThumbnail"
                    class="text-red-600 hover:text-red-900 text-sm font-medium"
                  >
                    Delete Thumbnail
                  </button>
                </div>
              </div>

              <!-- Thumbnail Upload -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Upload Thumbnail
                </label>
                <div class="flex items-center space-x-4">
                  <input
                    ref="thumbnailInput"
                    type="file"
                    accept="image/*"
                    @change="handleThumbnailUpload"
                    class="hidden"
                  />
                  <button
                    type="button"
                    @click="() => ($refs.thumbnailInput as HTMLInputElement)?.click()"
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700"
                  >
                    Choose Image
                  </button>
                  <span v-if="thumbnailFile" class="text-sm text-gray-600">
                    {{ thumbnailFile.name }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                  Supported formats: JPEG, PNG, JPG, GIF (Max 2MB)
                </p>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <Link
                :href="route('admin.courses.edit', lesson.course_id)"
                class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50"
              >
                Back to Course
              </Link>
              
              <button
                type="submit"
                :disabled="form.processing"
                class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="form.processing">Updating...</span>
                <span v-else>Update Lesson</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import { Link } from '@inertiajs/vue3'

interface Lesson {
  id: number
  course_id: number
  title: string
  description: string | null
  video_url: string | null
  video_file: string | null
  video_filename: string | null
  video_size: number | null
  video_duration: string | null
  thumbnail: string | null
  thumbnail_url: string | null
  order: number
  is_free: boolean
}

interface Props {
  lesson: Lesson
}

const props = defineProps<Props>()

const videoFile = ref<File | null>(null)
const thumbnailFile = ref<File | null>(null)
const videoInput = ref<HTMLInputElement>()
const thumbnailInput = ref<HTMLInputElement>()

const form = useForm({
  title: props.lesson.title,
  description: props.lesson.description || '',
  video_url: props.lesson.video_url || '',
  order: props.lesson.order,
  is_free: props.lesson.is_free,
})

const handleVideoUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    videoFile.value = target.files[0]
    uploadVideo()
  }
}

const handleThumbnailUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    thumbnailFile.value = target.files[0]
    uploadThumbnail()
  }
}

const uploadVideo = async () => {
  if (!videoFile.value) return

  const formData = new FormData()
  formData.append('video', videoFile.value)

  try {
    const response = await fetch(route('admin.lessons.upload-video', props.lesson.id), {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
    })

    if (response.ok) {
      const result = await response.json()
      console.log('Video uploaded:', result)
      // Refresh the page to show the new video
      window.location.reload()
    }
  } catch (error) {
    console.error('Error uploading video:', error)
  }
}

const uploadThumbnail = async () => {
  if (!thumbnailFile.value) return

  const formData = new FormData()
  formData.append('thumbnail', thumbnailFile.value)

  try {
    const response = await fetch(route('admin.lessons.upload-thumbnail', props.lesson.id), {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
    })

    if (response.ok) {
      const result = await response.json()
      console.log('Thumbnail uploaded:', result)
      // Refresh the page to show the new thumbnail
      window.location.reload()
    }
  } catch (error) {
    console.error('Error uploading thumbnail:', error)
  }
}

const deleteVideo = async () => {
  if (!confirm('Are you sure you want to delete this video?')) return

  try {
    const response = await fetch(route('admin.lessons.delete-video', props.lesson.id), {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
    })

    if (response.ok) {
      window.location.reload()
    }
  } catch (error) {
    console.error('Error deleting video:', error)
  }
}

const deleteThumbnail = async () => {
  if (!confirm('Are you sure you want to delete this thumbnail?')) return

  try {
    const response = await fetch(route('admin.lessons.delete-thumbnail', props.lesson.id), {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
    })

    if (response.ok) {
      window.location.reload()
    }
  } catch (error) {
    console.error('Error deleting thumbnail:', error)
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const submit = () => {
  form.put(route('admin.lessons.update', props.lesson.id), {
    onSuccess: () => {
      // Redirect will be handled by the controller
    },
  })
}
</script> 