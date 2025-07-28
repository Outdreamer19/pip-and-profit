<template>
  <AppLayout>
    <template #header>
      <Heading title="Contact Us" description="Get in touch with our support team" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- Contact Form -->
          <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h2>
            
            <form @submit.prevent="submit" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    First Name
                  </label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                  />
                  <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                    {{ form.errors.name }}
                  </p>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                  </label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                  />
                  <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                    {{ form.errors.email }}
                  </p>
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Subject
                </label>
                <input
                  v-model="form.subject"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required
                />
                <p v-if="form.errors.subject" class="mt-1 text-sm text-red-600">
                  {{ form.errors.subject }}
                </p>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Message
                </label>
                <textarea
                  v-model="form.message"
                  rows="6"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required
                ></textarea>
                <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">
                  {{ form.errors.message }}
                </p>
              </div>
              
              <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="form.processing">Sending...</span>
                <span v-else>Send Message</span>
              </button>
            </form>
          </div>
          
          <!-- Contact Information -->
          <div class="space-y-8">
            <div>
              <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in touch</h2>
              <p class="text-gray-600 mb-6">
                Have questions about our courses or need technical support? 
                We're here to help you succeed in your trading journey.
              </p>
            </div>
            
            <div class="space-y-6">
              <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <Icon name="mail" class="w-5 h-5 text-indigo-600" />
                </div>
                <div>
                  <h3 class="font-semibold text-gray-900">Email Support</h3>
                  <p class="text-gray-600">support@pipandprofit.com</p>
                  <p class="text-sm text-gray-500">We typically respond within 24 hours</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <Icon name="clock" class="w-5 h-5 text-indigo-600" />
                </div>
                <div>
                  <h3 class="font-semibold text-gray-900">Business Hours</h3>
                  <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM EST</p>
                  <p class="text-sm text-gray-500">Weekend support available for urgent issues</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <Icon name="help-circle" class="w-5 h-5 text-indigo-600" />
                </div>
                <div>
                  <h3 class="font-semibold text-gray-900">Help Center</h3>
                  <p class="text-gray-600">Browse our knowledge base</p>
                  <p class="text-sm text-gray-500">Find answers to common questions</p>
                </div>
              </div>
            </div>
            
            <!-- FAQ Quick Links -->
            <div class="bg-gray-50 rounded-lg p-6">
              <h3 class="font-semibold text-gray-900 mb-4">Quick Questions</h3>
              <div class="space-y-3">
                <div class="flex items-center justify-between">
                  <span class="text-sm text-gray-600">How do I access my courses?</span>
                  <Icon name="chevron-right" class="w-4 h-4 text-gray-400" />
                </div>
                <div class="flex items-center justify-between">
                  <span class="text-sm text-gray-600">What payment methods do you accept?</span>
                  <Icon name="chevron-right" class="w-4 h-4 text-gray-400" />
                </div>
                <div class="flex items-center justify-between">
                  <span class="text-sm text-gray-600">Can I get a refund?</span>
                  <Icon name="chevron-right" class="w-4 h-4 text-gray-400" />
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
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: '',
})

const submit = () => {
  form.post(route('contact.store'), {
    onSuccess: () => {
      form.reset()
    },
  })
}
</script> 