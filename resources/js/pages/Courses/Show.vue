<template>
  <AppLayout>
    <template #header>
      <Heading :title="course.title" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Course Details -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="aspect-video bg-gray-200">
              <img
                v-if="course.image"
                :src="course.image"
                :alt="course.title"
                class="w-full h-full object-cover"
              />
              <div
                v-else
                class="w-full h-full flex items-center justify-center text-gray-400"
              >
                <Icon name="video" class="w-16 h-16" />
              </div>
            </div>
            
            <div class="p-6">
              <h1 class="text-3xl font-bold text-gray-900 mb-4">
                {{ course.title }}
              </h1>
              
              <p class="text-gray-600 mb-6 text-lg">
                {{ course.description }}
              </p>
              
              <div class="flex items-center justify-between mb-6">
                <div class="text-3xl font-bold text-indigo-600">
                  ${{ course.price }}
                </div>
                
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                  <span>{{ course.lessons.length }} lessons</span>
                  <span>•</span>
                  <span>Lifetime access</span>
                </div>
              </div>
              
              <div class="flex space-x-4">
                <TextLink
                  v-if="$page.props.auth.user"
                  :href="route('checkout', course.slug)"
                  class="flex-1 text-center bg-indigo-600 text-white hover:bg-indigo-700 py-3 px-6 rounded-lg font-semibold"
                >
                  Enroll Now
                </TextLink>
                
                <TextLink
                  :href="route('courses.index')"
                  class="flex-1 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 py-3 px-6 rounded-lg font-semibold"
                >
                  Back to Courses
                </TextLink>
              </div>
              
              <!-- Start Learning Button for enrolled users -->
              <div v-if="$page.props.auth.user && hasPurchasedCourse" class="mt-4">
                <TextLink
                  :href="route('lessons.show', { course: course.slug, lesson: course.lessons[0].id })"
                  class="w-full text-center bg-green-600 text-white hover:bg-green-700 py-3 px-6 rounded-lg font-semibold"
                >
                  Start Learning
                </TextLink>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Course Curriculum -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
              Course Curriculum
            </h3>
            
            <div class="space-y-3">
              <div
                v-for="(lesson, index) in course.lessons"
                :key="lesson.id"
                class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-gray-50"
              >
                <div class="flex items-center space-x-3">
                  <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-semibold">
                    {{ index + 1 }}
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-900">
                      {{ lesson.title }}
                    </h4>
                    <p class="text-sm text-gray-500">
                      {{ lesson.video_duration || 'Coming soon' }}
                    </p>
                  </div>
                </div>
                
                <div class="flex items-center space-x-2">
                  <span
                    v-if="lesson.is_free"
                    class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                  >
                    Free
                  </span>
                  <Icon name="lock" class="w-4 h-4 text-gray-400" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'
import TextLink from '@/components/TextLink.vue'

interface Lesson {
  id: number
  title: string
  description: string | null
  video_url: string | null
  video_duration: string | null
  order: number
  is_free: boolean
}

interface Course {
  id: number
  title: string
  slug: string
  price: number
  description: string
  image: string | null
  lessons: Lesson[]
}

interface Props {
  course: Course
}

defineProps<Props>()
const page = usePage()

// Check if user has purchased this course
const hasPurchasedCourse = computed(() => {
  const user = page.props.auth.user
  if (!user) return false
  
  // This would need to be passed from the backend
  // For now, we'll assume false and handle it in the backend
  return false
})
</script> 