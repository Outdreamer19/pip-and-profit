<template>
  <AppLayout>
    <template #header>
      <Heading title="Create Course" description="Add a new course to the platform" />
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
              
              <button
                type="submit"
                :disabled="form.processing"
                class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="form.processing">Creating...</span>
                <span v-else>Create Course</span>
              </button>
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
import { Link } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  description: '',
  price: '',
  image: '',
  is_published: false,
})

const submit = () => {
  form.post(route('admin.courses.store'), {
    onSuccess: () => {
      // Redirect will be handled by the controller
    },
  })
}
</script> 