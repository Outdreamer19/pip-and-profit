<template>
  <AppLayout>
    <template #header>
      <Heading title="Checkout" />
    </template>

    <div class="container mx-auto px-4 py-8">
      <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
              Complete Your Purchase
            </h2>
            
            <!-- Course Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
              <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <Icon name="video" class="w-8 h-8 text-indigo-600" />
                </div>
                <div class="flex-1">
                  <h3 class="text-lg font-semibold text-gray-900">
                    {{ course.title }}
                  </h3>
                  <p class="text-gray-600">
                    {{ course.lessons?.length || 0 }} lessons
                  </p>
                </div>
                <div class="text-2xl font-bold text-indigo-600">
                  ${{ course.price }}
                </div>
              </div>
            </div>
            
            <!-- Payment Form -->
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Card Information
                </label>
                <div
                  ref="cardElement"
                  class="border border-gray-300 rounded-md p-3 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500"
                ></div>
                <p v-if="error" class="mt-2 text-sm text-red-600">
                  {{ error }}
                </p>
              </div>
              
              <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div>
                  <p class="text-sm text-gray-600">Total</p>
                  <p class="text-2xl font-bold text-gray-900">
                    ${{ course.price }}
                  </p>
                </div>
                
                <button
                  type="submit"
                  :disabled="loading"
                  class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="loading">Processing...</span>
                  <span v-else>Pay Now</span>
                </button>
              </div>
            </form>
            
            <!-- Security Notice -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
              <div class="flex items-center space-x-2">
                <Icon name="shield" class="w-5 h-5 text-blue-600" />
                <p class="text-sm text-blue-800">
                  Your payment is secured by Stripe. We never store your card information.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import Heading from '@/components/Heading.vue'
import Icon from '@/components/Icon.vue'

interface Course {
  id: number
  title: string
  slug: string
  price: number
  description: string
  image: string | null
  lessons: any[]
}

interface Props {
  course: Course
  stripeKey: string
}

const props = defineProps<Props>()

const cardElement = ref<HTMLElement>()
const loading = ref(false)
const error = ref('')

let stripe: any
let card: any

onMounted(() => {
  // Load Stripe
  const script = document.createElement('script')
  script.src = 'https://js.stripe.com/v3/'
  script.onload = () => {
    stripe = (window as any).Stripe(props.stripeKey)
    const elements = stripe.elements()
    card = elements.create('card', {
      style: {
        base: {
          fontSize: '16px',
          color: '#424770',
          '::placeholder': {
            color: '#aab7c4',
          },
        },
        invalid: {
          color: '#9e2146',
        },
      },
    })
    card.mount(cardElement.value)
  }
  document.head.appendChild(script)
})

const handleSubmit = async () => {
  if (!stripe || !card) return

  loading.value = true
  error.value = ''

  try {
    const { paymentMethod, error: stripeError } = await stripe.createPaymentMethod({
      type: 'card',
      card,
    })

    if (stripeError) {
      error.value = stripeError.message
      loading.value = false
      return
    }

    // Send to backend
    const response = await fetch(route('checkout.process', props.course.slug), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
      },
      body: JSON.stringify({
        payment_method_id: paymentMethod.id,
      }),
    })

    const result = await response.json()

    if (result.success) {
      router.visit(result.redirect)
    } else {
      error.value = result.error || 'Payment failed. Please try again.'
    }
  } catch {
    error.value = 'An error occurred. Please try again.'
  }

  loading.value = false
}
</script> 