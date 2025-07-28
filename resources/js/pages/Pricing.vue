<template>
  <AppLayout>
    <template #header>
      <Heading title="Pricing" description="Choose the perfect course for your trading journey" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <!-- Pricing Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Choose Your Trading Path
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Start with our foundational courses and progress to advanced strategies. 
          Each course is designed to take you from beginner to expert trader.
        </p>
      </div>

      <!-- Course Pricing Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <div
          v-for="course in courses"
          :key="course.id"
          class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow"
        >
          <div class="p-8">
            <div class="text-center mb-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">
                {{ course.title }}
              </h3>
              <p class="text-gray-600 mb-4">
                {{ course.description }}
              </p>
              <div class="text-4xl font-bold text-indigo-600 mb-2">
                ${{ course.price }}
              </div>
              <p class="text-sm text-gray-500">One-time payment</p>
            </div>

            <div class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-3">What's included:</h4>
              <ul class="space-y-2">
                <li class="flex items-center text-sm text-gray-600">
                  <Icon name="check" class="w-4 h-4 text-green-500 mr-2" />
                  {{ course.lessons.length }} video lessons
                </li>
                <li class="flex items-center text-sm text-gray-600">
                  <Icon name="check" class="w-4 h-4 text-green-500 mr-2" />
                  Lifetime access
                </li>
                <li class="flex items-center text-sm text-gray-600">
                  <Icon name="check" class="w-4 h-4 text-green-500 mr-2" />
                  Downloadable resources
                </li>
                <li class="flex items-center text-sm text-gray-600">
                  <Icon name="check" class="w-4 h-4 text-green-500 mr-2" />
                  Certificate of completion
                </li>
              </ul>
            </div>

            <div class="space-y-3">
              <TextLink
                :href="route('courses.show', course.slug)"
                class="w-full text-center bg-indigo-600 text-white hover:bg-indigo-700 py-3 px-6 rounded-lg font-semibold"
              >
                View Course Details
              </TextLink>
              
              <TextLink
                v-if="$page.props.auth.user"
                :href="route('checkout', course.slug)"
                class="w-full text-center border border-indigo-600 text-indigo-600 hover:bg-indigo-50 py-3 px-6 rounded-lg font-semibold"
              >
                Enroll Now
              </TextLink>
              
              <TextLink
                v-else
                :href="route('register')"
                class="w-full text-center border border-indigo-600 text-indigo-600 hover:bg-indigo-50 py-3 px-6 rounded-lg font-semibold"
              >
                Sign Up to Enroll
              </TextLink>
            </div>
          </div>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="bg-gray-50 rounded-lg p-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
          Frequently Asked Questions
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              How long do I have access to the courses?
            </h3>
            <p class="text-gray-600">
              You have lifetime access to all courses you purchase. You can watch them as many times as you want.
            </p>
          </div>
          
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              Can I get a refund?
            </h3>
            <p class="text-gray-600">
              We offer a 30-day money-back guarantee. If you're not satisfied, contact us for a full refund.
            </p>
          </div>
          
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              Do I need any prior trading experience?
            </h3>
            <p class="text-gray-600">
              No prior experience is required. Our courses start from the basics and progress to advanced strategies.
            </p>
          </div>
          
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              Are the courses updated regularly?
            </h3>
            <p class="text-gray-600">
              Yes, we regularly update our courses to reflect the latest market conditions and trading strategies.
            </p>
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