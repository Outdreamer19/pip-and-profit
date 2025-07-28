<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Mail, Lock, Eye, EyeOff } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Welcome back" description="Sign in to your account to continue your trading journey">
        <Head title="Log in" />

        <div v-if="status" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm font-medium text-green-800">{{ status }}</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-4">
                <div class="space-y-2">
                    <Label for="email" class="text-sm font-medium text-gray-700">Email address</Label>
                    <div class="relative">
                        <Mail class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <Input
                            id="email"
                            type="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="Enter your email"
                            class="pl-10 h-12 border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        />
                    </div>
                    <InputError :message="form.errors.email" />
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-sm font-medium text-gray-700">Password</Label>
                        <TextLink 
                            v-if="canResetPassword" 
                            :href="route('password.request')" 
                            class="text-sm text-teal-600 hover:text-teal-700" 
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <Input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            v-model="form.password"
                            placeholder="Enter your password"
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

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3 cursor-pointer">
                        <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                        <span class="text-sm text-gray-700">Remember me</span>
                    </Label>
                </div>

                <Button 
                    type="submit" 
                    class="w-full h-12 bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white font-medium" 
                    :tabindex="4" 
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                    Sign In
                </Button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <TextLink :href="route('register')" class="text-teal-600 hover:text-teal-700 font-medium ml-1" :tabindex="5">
                        Create account
                    </TextLink>
                </p>
            </div>
        </form>
    </AuthBase>
</template>
