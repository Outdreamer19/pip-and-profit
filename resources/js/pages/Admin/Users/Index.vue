<template>
  <AppLayout>
    <template #header>
      <Heading title="User Management" description="Manage all users in the system" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
              <Icon name="users" class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Users</p>
              <p class="text-2xl font-bold text-gray-900">{{ users.total }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
              <Icon name="user-check" class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Active Users</p>
              <p class="text-2xl font-bold text-gray-900">{{ activeUsers }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
              <Icon name="crown" class="w-6 h-6 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Admin Users</p>
              <p class="text-2xl font-bold text-gray-900">{{ adminUsers }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Users Table -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">All Users</h3>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  User
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Role
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Orders
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Joined
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-sm font-medium text-indigo-600">
                          {{ getInitials(user.name) }}
                        </span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ user.name }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ user.email }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="{
                      'bg-purple-100 text-purple-800': user.role === 'admin',
                      'bg-gray-100 text-gray-800': user.role === 'user',
                    }"
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  >
                    {{ user.role }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ user.orders_count || 0 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(user.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="{
                      'bg-green-100 text-green-800': user.email_verified_at,
                      'bg-yellow-100 text-yellow-800': !user.email_verified_at,
                    }"
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  >
                    {{ user.email_verified_at ? 'Verified' : 'Pending' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end space-x-2">
                    <button
                      @click="editUser(user)"
                      class="text-indigo-600 hover:text-indigo-900 p-1"
                    >
                      <Icon name="edit" class="w-4 h-4" />
                    </button>
                    <button
                      @click="viewUserDetails(user)"
                      class="text-gray-600 hover:text-gray-900 p-1"
                    >
                      <Icon name="eye" class="w-4 h-4" />
                    </button>
                    <button
                      v-if="user.role !== 'admin'"
                      @click="deleteUser(user)"
                      class="text-red-600 hover:text-red-900 p-1"
                    >
                      <Icon name="trash" class="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="users.links" class="px-6 py-3 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing {{ users.from }} to {{ users.to }} of {{ users.total }} results
            </div>
            <div class="flex space-x-2">
              <Link
                v-for="link in users.links"
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
  role: string
  email_verified_at: string | null
  created_at: string
  orders_count?: number
}

interface PaginatedUsers {
  data: User[]
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
  users: PaginatedUsers
}

const props = defineProps<Props>()

const getInitials = (name: string) => {
  return name
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const activeUsers = computed(() => {
  return props.users.data.filter(user => user.email_verified_at).length
})

const adminUsers = computed(() => {
  return props.users.data.filter(user => user.role === 'admin').length
})

const editUser = (user: User) => {
  // TODO: Implement user editing
  console.log('Edit user:', user)
}

const viewUserDetails = (user: User) => {
  // TODO: Implement user details view
  console.log('View user details:', user)
}

const deleteUser = (user: User) => {
  // TODO: Implement user deletion
  console.log('Delete user:', user)
}
</script> 