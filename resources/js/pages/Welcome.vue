<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Icon from '@/components/Icon.vue'

defineProps<{
  auth: {
    user: any
  }
}>()
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold text-indigo-600">Pip & Profit</h1>
          </div>
          <div class="flex items-center space-x-4">
            <Link
              :href="route('courses.index')"
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium"
            >
              Courses
            </Link>
            <Link
              :href="route('pricing')"
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium"
            >
              Pricing
            </Link>
            <Link
              :href="route('contact')"
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium"
            >
              Contact
            </Link>
            <Link
              v-if="$page.props.auth.user"
              :href="route('dashboard')"
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium"
            >
              Dashboard
            </Link>
            <template v-else>
              <Link
                :href="route('login')"
                class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium"
              >
                Log in
              </Link>
              <Link
                :href="route('register')"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700"
              >
                Sign up
              </Link>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
      <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
          <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
            <div class="sm:text-center lg:text-left">
              <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block xl:inline">Master Forex &</span>
                <span class="block text-indigo-600 xl:inline">Volatility Trading</span>
              </h1>
              <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                Learn from expert traders and master the art of Forex and volatility trading. 
                Our comprehensive courses will take you from beginner to advanced trader.
              </p>
              <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                  <Link
                    :href="route('courses.index')"
                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"
                  >
                    Browse Courses
                  </Link>
                </div>
                <div class="mt-3 sm:mt-0 sm:ml-3">
                  <Link
                    :href="route('register')"
                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10"
                  >
                    Start Learning
                  </Link>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
          <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Features</h2>
          <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            Why Choose Our Platform
          </p>
        </div>

        <div class="mt-10">
          <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <Icon name="video" class="h-6 w-6" />
              </div>
              <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Video Lessons</p>
              <p class="mt-2 ml-16 text-base text-gray-500">
                High-quality video lessons with expert instructors covering all aspects of trading.
              </p>
            </div>

            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <Icon name="shield" class="h-6 w-6" />
              </div>
              <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Secure Payments</p>
              <p class="mt-2 ml-16 text-base text-gray-500">
                Safe and secure payment processing with Stripe integration.
              </p>
            </div>

            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <Icon name="clock" class="h-6 w-6" />
              </div>
              <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Lifetime Access</p>
              <p class="mt-2 ml-16 text-base text-gray-500">
                Once you purchase a course, you have lifetime access to all content.
              </p>
            </div>

            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <Icon name="users" class="h-6 w-6" />
              </div>
              <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Expert Community</p>
              <p class="mt-2 ml-16 text-base text-gray-500">
                Join our community of traders and learn from experienced professionals.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
      <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
          <span class="block">Ready to start trading?</span>
          <span class="block">Start your journey today.</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-indigo-200">
          Join thousands of traders who have already transformed their trading skills with our courses.
        </p>
        <Link
          :href="route('courses.index')"
          class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto"
        >
          Browse Courses
        </Link>
      </div>
    </div>
  </div>
</template>
