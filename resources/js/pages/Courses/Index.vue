<template>
  <AppLayout>
    <template #header>
      <Heading title="Available Courses" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="course in courses"
          :key="course.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
        >
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
              <Icon name="video" class="w-12 h-12" />
            </div>
          </div>
          
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
              {{ course.title }}
            </h3>
            
            <p class="text-gray-600 mb-4 line-clamp-3">
              {{ course.description }}
            </p>
            
            <div class="flex items-center justify-between">
              <div class="text-2xl font-bold text-indigo-600">
                ${{ course.price }}
              </div>
              
              <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">
                  {{ course.lessons.length }} lessons
                </span>
              </div>
            </div>
            
            <div class="mt-4 flex space-x-2">
              <TextLink
                :href="route('courses.show', course.slug)"
                class="flex-1 text-center"
              >
                View Course
              </TextLink>
              
              <TextLink
                v-if="$page.props.auth.user"
                :href="route('checkout', course.slug)"
                class="flex-1 text-center bg-indigo-600 text-white hover:bg-indigo-700"
              >
                Enroll Now
              </TextLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'
import TextLink from '@/components/TextLink.vue'

interface Course {
  id: number
  title: string
  slug: string
  price: number
  description: string
  image: string | null
  lessons: any[]
}

interface Props {
  courses: Course[]
}

defineProps<Props>()
</script> 