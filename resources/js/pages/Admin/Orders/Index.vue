<template>
  <AppLayout>
    <template #header>
      <Heading title="Orders & Payments" description="Manage all orders and payment transactions" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
              <Icon name="shopping-cart" class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Orders</p>
              <p class="text-2xl font-bold text-gray-900">{{ orders.total }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
              <Icon name="check-circle" class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Completed</p>
              <p class="text-2xl font-bold text-gray-900">{{ completedOrders }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
              <Icon name="clock" class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending</p>
              <p class="text-2xl font-bold text-gray-900">{{ pendingOrders }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
              <Icon name="dollar-sign" class="w-6 h-6 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Revenue</p>
              <p class="text-2xl font-bold text-gray-900">${{ totalRevenue }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Orders Table -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">All Orders</h3>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Order
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Customer
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Course
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Amount
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    #{{ order.id }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ order.stripe_payment_intent_id ? `Stripe: ${order.stripe_payment_intent_id.slice(-8)}` : 'No Stripe ID' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ order.user.name }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ order.user.email }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">
                    {{ order.course.title }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ order.course.lessons.length }} lessons
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  ${{ order.amount }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="{
                      'bg-green-100 text-green-800': order.status === 'completed',
                      'bg-yellow-100 text-yellow-800': order.status === 'pending',
                      'bg-red-100 text-red-800': order.status === 'failed',
                      'bg-gray-100 text-gray-800': order.status === 'refunded',
                    }"
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  >
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(order.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end space-x-2">
                    <button
                      @click="viewOrderDetails(order)"
                      class="text-indigo-600 hover:text-indigo-900 p-1"
                    >
                      <Icon name="eye" class="w-4 h-4" />
                    </button>
                    <button
                      v-if="order.status === 'completed'"
                      @click="refundOrder(order)"
                      class="text-red-600 hover:text-red-900 p-1"
                    >
                      <Icon name="refresh-cw" class="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="orders.links" class="px-6 py-3 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing {{ orders.from }} to {{ orders.to }} of {{ orders.total }} results
            </div>
            <div class="flex space-x-2">
              <Link
                v-for="link in orders.links"
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
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'

interface User {
  id: number
  name: string
  email: string
}

interface Course {
  id: number
  title: string
  lessons: any[]
}

interface Order {
  id: number
  amount: number
  status: string
  stripe_payment_intent_id: string | null
  created_at: string
  user: User
  course: Course
}

interface PaginatedOrders {
  data: Order[]
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
  orders: PaginatedOrders
}

const props = defineProps<Props>()

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const completedOrders = computed(() => {
  return props.orders.data.filter(order => order.status === 'completed').length
})

const pendingOrders = computed(() => {
  return props.orders.data.filter(order => order.status === 'pending').length
})

const totalRevenue = computed(() => {
  return props.orders.data
    .filter(order => order.status === 'completed')
    .reduce((sum, order) => sum + order.amount, 0)
    .toFixed(2)
})

const viewOrderDetails = (order: Order) => {
  // TODO: Implement order details view
  console.log('View order details:', order)
}

const refundOrder = (order: Order) => {
  // TODO: Implement order refund
  console.log('Refund order:', order)
}
</script> 