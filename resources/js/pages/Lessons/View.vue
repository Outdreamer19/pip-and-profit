<template>
  <AppLayout>
    <template #header>
      <Heading :title="lesson.title" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Video Player -->
        <div class="lg:col-span-2">
          <VideoPlayer
            :video-url="lesson.video_url"
            :lesson-title="lesson.title"
            :lesson-description="lesson.description || ''"
            :lesson-id="lesson.id"
          />
        </div>
        
        <!-- Course Navigation -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
              Course Curriculum
            </h3>
            
            <div class="space-y-2">
              <div
                v-for="courseLesson in course.lessons"
                :key="courseLesson.id"
                class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-gray-50"
                :class="{
                  'bg-indigo-50 border-indigo-200': courseLesson.id === lesson.id,
                  'cursor-pointer': courseLesson.id !== lesson.id
                }"
                @click="courseLesson.id !== lesson.id && navigateToLesson(courseLesson)"
              >
                <div class="flex items-center space-x-3">
                  <div
                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold"
                    :class="{
                      'bg-indigo-600 text-white': courseLesson.id === lesson.id,
                      'bg-gray-100 text-gray-600': courseLesson.id !== lesson.id
                    }"
                  >
                    {{ courseLesson.order }}
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-900">
                      {{ courseLesson.title }}
                    </h4>
                    <p class="text-sm text-gray-500">
                      {{ courseLesson.video_duration || 'Coming soon' }}
                    </p>
                  </div>
                </div>
                
                <div class="flex items-center space-x-2">
                  <span
                    v-if="courseLesson.is_free"
                    class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                  >
                    Free
                  </span>
                  <Icon
                    v-if="courseLesson.id === lesson.id"
                    name="play"
                    class="w-4 h-4 text-indigo-600"
                  />
                  <Icon
                    v-else
                    name="lock"
                    class="w-4 h-4 text-gray-400"
                  />
                </div>
              </div>
            </div>
          </div>
          
          <!-- Course Info -->
          <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
              About This Course
            </h3>
            
            <div class="space-y-4">
              <div>
                <h4 class="font-medium text-gray-900">{{ course.title }}</h4>
                <p class="text-sm text-gray-600 mt-1">
                  {{ course.description }}
                </p>
              </div>
              
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">Total Lessons</span>
                <span class="font-medium">{{ course.lessons.length }}</span>
              </div>
              
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">Course Price</span>
                <span class="font-medium text-indigo-600">${{ course.price }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'
import VideoPlayer from '@/components/VideoPlayer.vue'

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
  lesson: Lesson
  course: Course
}

const props = defineProps<Props>()

const navigateToLesson = (lesson: Lesson) => {
  router.visit(route('lessons.show', { course: props.course.slug, lesson: lesson.id }))
}
</script> 