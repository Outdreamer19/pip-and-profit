<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100 flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <Card class="border-0 shadow-2xl">
                <CardHeader class="text-center pb-6">
                    <Link :href="route('home')" class="flex flex-col items-center gap-3 mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-teal-500 to-blue-600">
                            <AppLogoIcon class="size-8 fill-current text-white" />
                        </div>
                        <div class="text-center">
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">
                                Pip & Profit
                            </h1>
                            <p class="text-sm text-gray-500">Master Forex & Volatility Trading</p>
                        </div>
                    </Link>
                    
                    <div class="space-y-2">
                        <CardTitle class="text-2xl font-bold text-gray-900">{{ title }}</CardTitle>
                        <CardDescription class="text-base text-gray-600">{{ description }}</CardDescription>
                    </div>
                </CardHeader>
                
                <CardContent class="pt-0">
                    <slot />
                </CardContent>
            </Card>
            
            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <div class="flex justify-center space-x-6 text-sm text-gray-500">
                    <Link :href="route('home')" class="hover:text-teal-600 transition-colors">
                        Home
                    </Link>
                    <Link :href="route('courses.index')" class="hover:text-teal-600 transition-colors">
                        Courses
                    </Link>
                    <Link :href="route('pricing')" class="hover:text-teal-600 transition-colors">
                        Pricing
                    </Link>
                    <Link :href="route('contact')" class="hover:text-teal-600 transition-colors">
                        Contact
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
