<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, User, Mail, Lock, Eye, EyeOff, CheckCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Join Pip & Profit" description="Create your account to start your trading education journey">
        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-4">
                <div class="space-y-2">
                    <Label for="name" class="text-sm font-medium text-gray-700">Full name</Label>
                    <div class="relative">
                        <User class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <Input 
                            id="name" 
                            type="text" 
                            required 
                            autofocus 
                            :tabindex="1" 
                            autocomplete="name" 
                            v-model="form.name" 
                            placeholder="Enter your full name"
                            class="pl-10 h-12 border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        />
                    </div>
                    <InputError :message="form.errors.name" />
                </div>

                <div class="space-y-2">
                    <Label for="email" class="text-sm font-medium text-gray-700">Email address</Label>
                    <div class="relative">
                        <Mail class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <Input 
                            id="email" 
                            type="email" 
                            required 
                            :tabindex="2" 
                            autocomplete="email" 
                            v-model="form.email" 
                            placeholder="Enter your email address"
                            class="pl-10 h-12 border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        />
                    </div>
                    <InputError :message="form.errors.email" />
                </div>

                <div class="space-y-2">
                    <Label for="password" class="text-sm font-medium text-gray-700">Password</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <Input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            :tabindex="3"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="Create a strong password"
                            class="pl-10 pr-10 h-12 border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        >
                            <Eye v-if="!showPassword" class="h-4 w-4" />
                            <EyeOff v-else class="h-4 w-4" />
                        </button>
                    </div>
                    <InputError :message="form.errors.password" />
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm password</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <Input
                            id="password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            required
                            :tabindex="4"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Confirm your password"
                            class="pl-10 pr-10 h-12 border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        />
                        <button
                            type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        >
                            <Eye v-if="!showConfirmPassword" class="h-4 w-4" />
                            <EyeOff v-else class="h-4 w-4" />
                        </button>
                    </div>
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- Benefits Section -->
                <div class="bg-gradient-to-r from-teal-50 to-blue-50 rounded-lg p-4 space-y-3">
                    <h4 class="font-medium text-gray-900 flex items-center">
                        <CheckCircle class="h-4 w-4 text-teal-600 mr-2" />
                        What you'll get:
                    </h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Access to premium trading courses</li>
                        <li>• Expert-led video lessons</li>
                        <li>• Community of traders</li>
                        <li>• Lifetime access to purchased content</li>
                    </ul>
                </div>

                <Button 
                    type="submit" 
                    class="w-full h-12 bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white font-medium" 
                    tabindex="5" 
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                    Create Account
                </Button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <TextLink :href="route('login')" class="text-teal-600 hover:text-teal-700 font-medium ml-1">
                        Sign in
                    </TextLink>
                </p>
            </div>
        </form>
    </AuthBase>
</template>
