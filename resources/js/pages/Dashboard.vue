<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Icon from '@/components/Icon.vue';
import TextLink from '@/components/TextLink.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Course {
    id: number;
    title: string;
    slug: string;
    price: number;
    description: string;
    image: string | null;
    lessons: any[];
}

interface Order {
    id: number;
    amount: number;
    status: string;
    created_at: string;
    course: Course;
}

interface Stats {
    total_courses_purchased: number;
    total_spent: number;
    recent_activity: number;
}

interface Props {
    purchasedCourses: Course[];
    recentOrders: Order[];
    stats: Stats;
}

defineProps<Props>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto px-4 py-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Welcome back, {{ $page.props.auth.user.name }}!
                </h1>
                <p class="text-gray-600 mt-2">
                    Continue your learning journey with your purchased courses.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <Icon name="book-open" class="w-6 h-6 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Courses Purchased</p>
                            <p class="text-2xl font-bold text-gray-900">{{ stats.total_courses_purchased }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <Icon name="dollar-sign" class="w-6 h-6 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Spent</p>
                            <p class="text-2xl font-bold text-gray-900">${{ stats.total_spent }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <Icon name="activity" class="w-6 h-6 text-purple-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Recent Activity</p>
                            <p class="text-2xl font-bold text-gray-900">{{ stats.recent_activity }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Courses Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">My Courses</h2>
                    <TextLink :href="route('courses.index')" class="text-indigo-600 hover:text-indigo-700">
                        Browse All Courses
                    </TextLink>
                </div>

                <div v-if="purchasedCourses.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="course in purchasedCourses"
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
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">
                                {{ course.description }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-500">
                                    {{ course.lessons.length }} lessons
                                </span>
                                <span class="text-sm font-medium text-green-600">
                                    Purchased
                                </span>
                            </div>
                            
                            <TextLink
                                :href="route('courses.show', course.slug)"
                                class="w-full text-center bg-indigo-600 text-white hover:bg-indigo-700 py-2 px-4 rounded-lg"
                            >
                                Continue Learning
                            </TextLink>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-12">
                    <Icon name="book-open" class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No courses purchased yet</h3>
                    <p class="text-gray-600 mb-6">Start your learning journey by browsing our courses.</p>
                    <TextLink
                        :href="route('courses.index')"
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700"
                    >
                        Browse Courses
                    </TextLink>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div v-if="recentOrders.length > 0">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Orders</h2>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="space-y-4">
                            <div
                                v-for="order in recentOrders"
                                :key="order.id"
                                class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
                            >
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                        <Icon name="shopping-cart" class="w-5 h-5 text-indigo-600" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ order.course.title }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ new Date(order.created_at).toLocaleDateString() }}
                                        </p>
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
            </div>
        </div>
    </AppLayout>
</template>
