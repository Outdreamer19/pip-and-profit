<template>
  <AppLayout>
    <template #header>
      <Heading title="Admin Dashboard" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
              <Icon name="users" class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Users</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.total_users }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
              <Icon name="video" class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Courses</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.total_courses }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
              <Icon name="shopping-cart" class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Orders</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.total_orders }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-indigo-100 rounded-lg">
              <Icon name="dollar-sign" class="w-6 h-6 text-indigo-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Revenue</p>
              <p class="text-2xl font-bold text-gray-900">${{ stats.total_revenue }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md">
          <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              <div
                v-for="order in recent_orders"
                :key="order.id"
                class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
              >
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                    <Icon name="user" class="w-5 h-5 text-gray-600" />
                  </div>
                  <div>
                    <p class="font-medium text-gray-900">{{ order.user.name }}</p>
                    <p class="text-sm text-gray-500">{{ order.course.title }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="font-semibold text-gray-900">${{ order.amount }}</p>
                  <span
                    :class="{
                      'bg-green-100 text-green-800': order.status === 'completed',
                      'bg-yellow-100 text-yellow-800': order.status === 'pending',
                      'bg-red-100 text-red-800': order.status === 'failed',
                    }"
                    class="text-xs px-2 py-1 rounded-full"
                  >
                    {{ order.status }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Courses -->
        <div class="bg-white rounded-lg shadow-md">
          <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Courses</h3>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              <div
                v-for="course in recent_courses"
                :key="course.id"
                class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
              >
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <Icon name="video" class="w-5 h-5 text-indigo-600" />
                  </div>
                  <div>
                    <p class="font-medium text-gray-900">{{ course.title }}</p>
                    <p class="text-sm text-gray-500">{{ course.lessons.length }} lessons</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="font-semibold text-gray-900">${{ course.price }}</p>
                  <span
                    :class="{
                      'bg-green-100 text-green-800': course.is_published,
                      'bg-gray-100 text-gray-800': !course.is_published,
                    }"
                    class="text-xs px-2 py-1 rounded-full"
                  >
                    {{ course.is_published ? 'Published' : 'Draft' }}
                  </span>
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
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'

interface Stats {
  total_users: number
  total_courses: number
  total_orders: number
  total_revenue: number
}

interface Order {
  id: number
  amount: number
  status: string
  user: {
    name: string
  }
  course: {
    title: string
  }
}

interface Course {
  id: number
  title: string
  price: number
  is_published: boolean
  lessons: any[]
}

interface Props {
  stats: Stats
  recent_orders: Order[]
  recent_courses: Course[]
}

defineProps<Props>()
</script> 