<template>
  <AppLayout>
    <template #header>
      <Heading title="Create Course" description="Add a new course to the platform" />
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
                  <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
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
                <span class="ml-2 text-sm text-gray-700">Publish this course immediately</span>
              </label>
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
                  <span v-if="form.processing">Creating...</span>
                  <span v-else>Create Course</span>
                </button>
                
                <Link
                  :href="route('admin.courses.index')"
                  class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700"
                >
                  View All Courses
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
import { Link } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  description: '',
  price: '',
  image: null as File | null,
  video: null as File | null,
  is_published: false,
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

const submit = () => {
  form.post(route('admin.courses.store'), {
    onSuccess: () => {
      // Redirect will be handled by the controller
    },
  })
}
</script> 