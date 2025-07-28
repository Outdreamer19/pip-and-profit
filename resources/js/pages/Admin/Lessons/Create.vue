<template>
  <AppLayout>
    <template #header>
      <Heading title="Create Lesson" description="Add a new lesson to the course" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
          <form @submit.prevent="submit" class="space-y-6">
            <!-- Course Info -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
              <h3 class="text-lg font-medium text-gray-900 mb-2">Course: {{ course.title }}</h3>
              <p class="text-sm text-gray-600">Adding lesson to this course</p>
            </div>

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
              
              <!-- Video Upload -->
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Video File
                  </label>
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
                      <p class="text-xs text-gray-500">MP4, AVI, MOV, WMV, FLV, WEBM up to 100MB</p>
                    </div>
                  </div>
                  <div v-if="selectedVideo" class="mt-2">
                    <p class="text-sm text-gray-600">Selected: {{ selectedVideo.name }}</p>
                  </div>
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
              <h3 class="text-lg font-medium text-gray-900 mb-4">Thumbnail (Optional)</h3>
              
              <!-- Thumbnail Upload -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Upload Thumbnail
                </label>
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
                        for="thumbnail-upload"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                      >
                        <span>Upload an image</span>
                        <input
                          id="thumbnail-upload"
                          ref="thumbnailInput"
                          type="file"
                          accept="image/*"
                          class="sr-only"
                          @change="handleThumbnailChange"
                        />
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                  </div>
                </div>
                <div v-if="selectedThumbnail" class="mt-2">
                  <p class="text-sm text-gray-600">Selected: {{ selectedThumbnail.name }}</p>
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <Link
                :href="route('admin.courses.edit', course.id)"
                class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50"
              >
                Cancel
              </Link>
              
              <button
                type="submit"
                :disabled="form.processing"
                class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="form.processing">Creating...</span>
                <span v-else>Create Lesson</span>
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

interface Course {
  id: number
  title: string
  slug: string
  lessons: any[]
}

interface Props {
  course: Course
}

const props = defineProps<Props>()

const selectedVideo = ref<File | null>(null)
const selectedThumbnail = ref<File | null>(null)
const videoInput = ref<HTMLInputElement>()
const thumbnailInput = ref<HTMLInputElement>()

const form = useForm({
  title: '',
  description: '',
  video_url: '',
  order: (props.course?.lessons?.length || 0) + 1,
  is_free: false,
})

// Debug logging
console.log('Course data:', props.course)
console.log('Course lessons:', props.course?.lessons)

const handleVideoChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedVideo.value = target.files[0]
  }
}

const handleThumbnailChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files[0]) {
    selectedThumbnail.value = target.files[0]
  }
}

const submit = () => {
  form.post(route('admin.lessons.store', props.course.slug), {
    onSuccess: () => {
      // Redirect will be handled by the controller
    },
  })
}
</script> 