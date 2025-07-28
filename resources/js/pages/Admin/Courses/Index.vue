<template>
  <AppLayout>
    <template #header>
      <Heading title="Course Management" description="Manage all courses in the system" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <!-- Action Bar -->
      <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <h2 class="text-lg font-semibold text-gray-900">All Courses</h2>
          <span class="text-sm text-gray-500">{{ courses.total }} courses</span>
        </div>
        <Link
          :href="route('admin.courses.create')"
          class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center space-x-2"
        >
          <Icon name="plus" class="w-4 h-4" />
          <span>Add Course</span>
        </Link>
      </div>

      <!-- Courses Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="course in courses.data"
          :key="course.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
        >
          <!-- Course Image -->
          <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
            <img
              v-if="course.image_url"
              :src="course.image_url"
              :alt="course.title"
              class="w-full h-full object-cover"
            />
            <Icon v-else name="video" class="w-16 h-16 text-gray-400" />
          </div>
          
          <!-- Course Content -->
          <div class="p-6">
            <div class="flex items-start justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">
                {{ course.title }}
              </h3>
              <span
                :class="{
                  'bg-green-100 text-green-800': course.is_published,
                  'bg-gray-100 text-gray-800': !course.is_published,
                }"
                class="text-xs px-2 py-1 rounded-full font-medium"
              >
                {{ course.is_published ? 'Published' : 'Draft' }}
              </span>
            </div>
            
            <p class="text-gray-600 mb-4 line-clamp-3">
              {{ course.description || 'No description available' }}
            </p>
            
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center space-x-4 text-sm text-gray-500">
                <span class="flex items-center space-x-1">
                  <Icon name="video" class="w-4 h-4" />
                  <span>{{ course.lessons.length }} lessons</span>
                </span>
                <span class="flex items-center space-x-1">
                  <Icon name="dollar-sign" class="w-4 h-4" />
                  <span>${{ course.price }}</span>
                </span>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-2">
              <Link
                :href="route('admin.courses.edit', course.slug)"
                class="flex-1 bg-indigo-600 text-white text-center py-2 px-4 rounded-lg hover:bg-indigo-700 text-sm font-medium"
              >
                Edit
              </Link>
              <Link
                :href="route('courses.show', course.slug)"
                class="flex-1 border border-gray-300 text-gray-700 text-center py-2 px-4 rounded-lg hover:bg-gray-50 text-sm font-medium"
              >
                View
              </Link>
              <button
                @click="deleteCourse(course)"
                class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg"
              >
                <Icon name="trash" class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="courses.links" class="mt-8">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Showing {{ courses.from }} to {{ courses.to }} of {{ courses.total }} results
          </div>
          <div class="flex space-x-2">
            <Link
              v-for="link in courses.links"
              :key="link.label"
              :href="link.url || '#'"
              :class="{
                'bg-indigo-600 text-white': link.active,
                'bg-white text-gray-700 hover:bg-gray-50': !link.active,
                'opacity-50 cursor-not-allowed': !link.url,
              }"
              class="px-3 py-2 text-sm font-medium rounded-md border"
            >
              <span v-html="link.label"></span>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'

interface Lesson {
  id: number
  title: string
}

interface Course {
  id: number
  title: string
  slug: string
  description: string | null
  price: number
  is_published: boolean
  lessons: Lesson[]
  image: string | null
  image_url: string | null
}

interface PaginatedCourses {
  data: Course[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number
  to: number
  links: Array<{
    url: string | null
    label: string
    active: boolean
  }>
}

interface Props {
  courses: PaginatedCourses
}

defineProps<Props>()

const deleteCourse = (course: Course) => {
  if (confirm(`Are you sure you want to delete "${course.title}"?`)) {
    // TODO: Implement course deletion with proper route
    console.log('Delete course:', course)
  }
}
</script> 