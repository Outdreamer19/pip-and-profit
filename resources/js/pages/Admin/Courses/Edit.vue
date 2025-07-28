<template>
  <AppLayout>
    <template #header>
      <Heading title="Edit Course" description="Update course information" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
          <form @submit.prevent="submit" class="space-y-6">
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

            <!-- Course Image URL -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Image URL (Optional)
              </label>
              <input
                v-model="form.image"
                type="url"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="https://example.com/image.jpg"
              />
              <p v-if="form.errors.image" class="mt-1 text-sm text-red-600">
                {{ form.errors.image }}
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
                    <button
                      type="button"
                      class="text-indigo-600 hover:text-indigo-900 p-1"
                    >
                      <Icon name="edit" class="w-4 h-4" />
                    </button>
                  </div>
                </div>
              </div>
              <button
                type="button"
                class="mt-3 text-indigo-600 hover:text-indigo-900 text-sm font-medium"
              >
                + Add Lesson
              </button>
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
                  class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700"
                >
                  View Course
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
  price: props.course.price.toString(),
  image: props.course.image || '',
  is_published: props.course.is_published,
})

const submit = () => {
  form.put(route('admin.courses.update', props.course.id), {
    onSuccess: () => {
      // Redirect will be handled by the controller
    },
  })
}
</script> 