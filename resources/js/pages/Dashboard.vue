<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardDescription, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { 
    BookOpen, 
    DollarSign, 
    TrendingUp, 
    Video, 
    ShoppingCart, 
    CheckCircle,
    Clock,
    Play,
    ArrowRight,
    Users,
    Star
} from 'lucide-vue-next';

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
            <!-- Welcome Section with Gradient Background -->
            <div class="relative mb-8 rounded-2xl bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100 p-8 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-teal-600/5 to-blue-600/5"></div>
                <div class="relative">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">
                        Welcome back, {{ $page.props.auth.user.name }}! 👋
                    </h1>
                    <p class="text-lg text-gray-600">
                        Continue your trading education journey with your purchased courses.
                    </p>
                    <div class="mt-4 flex items-center space-x-2 text-sm text-gray-500">
                        <Clock class="h-4 w-4" />
                        <span>Last login: {{ new Date().toLocaleDateString() }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <Card class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-0 shadow-lg">
                    <CardContent class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl">
                                <BookOpen class="w-6 h-6 text-white" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Courses Purchased</p>
                                <p class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">
                                    {{ stats.total_courses_purchased }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-0 shadow-lg">
                    <CardContent class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl">
                                <DollarSign class="w-6 h-6 text-white" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Invested</p>
                                <p class="text-3xl font-bold text-green-600">${{ stats.total_spent }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-0 shadow-lg">
                    <CardContent class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl">
                                <TrendingUp class="w-6 h-6 text-white" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Learning Progress</p>
                                <p class="text-3xl font-bold text-purple-600">{{ stats.recent_activity }}%</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- My Courses Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">My Courses</h2>
                        <p class="text-gray-600 mt-1">Continue where you left off</p>
                    </div>
                    <Button 
                        :href="route('courses.index')" 
                        class="bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white"
                    >
                        Browse All Courses
                        <ArrowRight class="ml-2 h-4 w-4" />
                    </Button>
                </div>

                <div v-if="purchasedCourses.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Card
                        v-for="course in purchasedCourses"
                        :key="course.id"
                        class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border-0 shadow-lg overflow-hidden"
                    >
                        <div class="relative">
                            <div class="aspect-video bg-gradient-to-br from-teal-500 to-blue-600 relative overflow-hidden">
                                <img
                                    v-if="course.image"
                                    :src="`/storage/course-images/${course.image}`"
                                    :alt="course.title"
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center"
                                >
                                    <Video class="w-12 h-12 text-white/80" />
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                        <CheckCircle class="h-3 w-3 mr-1" />
                                        Purchased
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <CardContent class="p-6">
                            <CardTitle class="text-xl mb-2">{{ course.title }}</CardTitle>
                            <CardDescription class="mb-4 line-clamp-2">
                                {{ course.description }}
                            </CardDescription>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <Video class="h-4 w-4 mr-1" />
                                        {{ course.lessons.length }} lessons
                                    </span>
                                    <span class="flex items-center">
                                        <Users class="h-4 w-4 mr-1" />
                                        1.2k students
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <Star class="h-4 w-4 text-yellow-400 fill-current" />
                                    <span class="text-sm font-medium text-gray-600 ml-1">4.8</span>
                                </div>
                            </div>
                            
                            <Button
                                :href="route('courses.show', course.slug)"
                                class="w-full bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white"
                            >
                                <Play class="mr-2 h-4 w-4" />
                                Continue Learning
                            </Button>
                        </CardContent>
                    </Card>
                </div>

                <div v-else class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gradient-to-r from-teal-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <BookOpen class="w-12 h-12 text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No courses purchased yet</h3>
                        <p class="text-gray-600 mb-8 text-lg">Start your trading education journey by exploring our comprehensive courses.</p>
                        <Button
                            :href="route('courses.index')"
                            class="bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white px-8 py-3 text-lg"
                        >
                            Browse Courses
                            <ArrowRight class="ml-2 h-5 w-5" />
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div v-if="recentOrders.length > 0">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Recent Orders</h2>
                        <p class="text-gray-600 mt-1">Your latest course purchases</p>
                    </div>
                </div>
                
                <Card class="border-0 shadow-lg">
                    <CardContent class="p-6">
                        <div class="space-y-4">
                            <div
                                v-for="order in recentOrders"
                                :key="order.id"
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors"
                            >
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <ShoppingCart class="w-6 h-6 text-white" />
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ order.course.title }}</p>
                                        <p class="text-sm text-gray-500">
                                            Purchased on {{ new Date(order.created_at).toLocaleDateString() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 text-lg">${{ order.amount }}</p>
                                    <span
                                        :class="{
                                            'bg-green-100 text-green-800': order.status === 'completed',
                                            'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                            'bg-red-100 text-red-800': order.status === 'failed',
                                        }"
                                        class="text-xs px-3 py-1 rounded-full font-medium"
                                    >
                                        {{ order.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Quick Actions Section -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Button
                        variant="outline"
                        class="h-auto p-6 flex flex-col items-center space-y-3 hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <BookOpen class="w-6 h-6 text-white" />
                        </div>
                        <span class="font-medium">Browse Courses</span>
                    </Button>
                    
                    <Button
                        variant="outline"
                        class="h-auto p-6 flex flex-col items-center space-y-3 hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <DollarSign class="w-6 h-6 text-white" />
                        </div>
                        <span class="font-medium">View Pricing</span>
                    </Button>
                    
                    <Button
                        variant="outline"
                        class="h-auto p-6 flex flex-col items-center space-y-3 hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                            <Users class="w-6 h-6 text-white" />
                        </div>
                        <span class="font-medium">Community</span>
                    </Button>
                    
                    <Button
                        variant="outline"
                        class="h-auto p-6 flex flex-col items-center space-y-3 hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                            <Star class="w-6 h-6 text-white" />
                        </div>
                        <span class="font-medium">Support</span>
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
