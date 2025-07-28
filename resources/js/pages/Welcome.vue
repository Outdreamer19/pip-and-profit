<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Icon from '@/components/Icon.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Separator } from '@/components/ui/separator'
import { 
  Play, 
  Star, 
  Users, 
  Clock, 
  TrendingUp, 
  Shield, 
  BookOpen,
  Check,
  Menu,
  X,
  ArrowRight
} from 'lucide-vue-next'
import { ref } from 'vue'

defineProps<{
  auth: {
    user: any
  }
}>()

const isMobileMenuOpen = ref(false)
const isVideoModalOpen = ref(false)
const activePricingToggle = ref('monthly')

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const toggleVideoModal = () => {
  isVideoModalOpen.value = !isVideoModalOpen.value
}

// Mock data for demonstration
const courseCategories = [
  {
    title: 'Forex Fundamentals',
    description: 'Master the basics of currency trading',
    icon: 'trending-up',
    lessons: 12,
    hours: 8
  },
  {
    title: 'Volatility Trading',
    description: 'Learn to profit from market volatility',
    icon: 'activity',
    lessons: 15,
    hours: 10
  },
  {
    title: 'Risk Management',
    description: 'Protect your capital with proper risk management',
    icon: 'shield',
    lessons: 8,
    hours: 6
  },
  {
    title: 'Advanced Strategies',
    description: 'Master advanced trading techniques',
    icon: 'zap',
    lessons: 20,
    hours: 15
  }
]

const featuredCourses = [
  {
    title: 'Complete Forex Trading Course',
    instructor: 'John Smith',
    instructorImage: '/placeholder-avatar.jpg',
    rating: 4.8,
    students: 1247,
    price: 199,
    originalPrice: 299,
    image: '/placeholder-course.jpg',
    level: 'Beginner'
  },
  {
    title: 'Volatility Trading Masterclass',
    instructor: 'Sarah Johnson',
    instructorImage: '/placeholder-avatar.jpg',
    rating: 4.9,
    students: 892,
    price: 249,
    originalPrice: 349,
    image: '/placeholder-course.jpg',
    level: 'Intermediate'
  },
  {
    title: 'Advanced Risk Management',
    instructor: 'Mike Chen',
    instructorImage: '/placeholder-avatar.jpg',
    rating: 4.7,
    students: 567,
    price: 179,
    originalPrice: 229,
    image: '/placeholder-course.jpg',
    level: 'Advanced'
  }
]

const testimonials = [
  {
    name: 'Alex Thompson',
    role: 'Professional Trader',
    image: '/placeholder-avatar.jpg',
    rating: 5,
    quote: 'This platform transformed my trading. The structured approach and expert guidance helped me go from losing money to consistent profits.'
  },
  {
    name: 'Maria Rodriguez',
    role: 'Part-time Trader',
    image: '/placeholder-avatar.jpg',
    rating: 5,
    quote: 'The volatility trading course was exactly what I needed. Clear explanations and practical strategies that actually work in real markets.'
  },
  {
    name: 'David Kim',
    role: 'Retail Trader',
    image: '/placeholder-avatar.jpg',
    rating: 5,
    quote: 'Best investment I\'ve made in my trading education. The risk management principles alone have saved me thousands.'
  }
]

const pricingPlans = [
  {
    name: 'Basic',
    price: 29,
    originalPrice: 49,
    description: 'Perfect for beginners starting their trading journey',
    features: [
      'Access to 2 courses',
      'Basic trading strategies',
      'Community forum access',
      'Email support',
      '30-day money-back guarantee'
    ],
    popular: false
  },
  {
    name: 'Pro',
    price: 79,
    originalPrice: 129,
    description: 'Comprehensive learning for serious traders',
    features: [
      'Access to all courses',
      'Advanced trading strategies',
      'Live market sessions',
      'Priority support',
      'Trading tools & indicators',
      'Monthly Q&A sessions',
      'Lifetime access'
    ],
    popular: true
  },
  {
    name: 'Elite',
    price: 199,
    originalPrice: 299,
    description: 'Complete mentorship program with personal guidance',
    features: [
      'Everything in Pro',
      '1-on-1 mentorship sessions',
      'Personal trading plan',
      'Direct access to instructors',
      'Custom trading strategies',
      'Weekly progress reviews',
      'Lifetime access + updates'
    ],
    popular: false
  }
]

const faqs = [
  {
    question: 'Do I need prior trading experience?',
    answer: 'No, our courses are designed for all skill levels. We start with the fundamentals and progress to advanced strategies.'
  },
  {
    question: 'How long do I have access to the courses?',
    answer: 'You have lifetime access to all purchased courses, including future updates and new content.'
  },
  {
    question: 'What if I\'m not satisfied with the course?',
    answer: 'We offer a 30-day money-back guarantee. If you\'re not completely satisfied, we\'ll refund your purchase.'
  },
  {
    question: 'Are the trading strategies tested?',
    answer: 'Yes, all strategies are thoroughly tested and used by our expert instructors in live markets.'
  }
]

const blogPosts = [
  {
    title: '5 Common Forex Trading Mistakes to Avoid',
    excerpt: 'Learn about the most common pitfalls that new traders face and how to avoid them.',
    category: 'Trading Tips',
    image: '/placeholder-blog.jpg',
    date: '2024-01-15'
  },
  {
    title: 'Understanding Market Volatility: A Complete Guide',
    excerpt: 'Master the concept of volatility and learn how to use it to your advantage.',
    category: 'Education',
    image: '/placeholder-blog.jpg',
    date: '2024-01-10'
  },
  {
    title: 'Risk Management Strategies for Forex Traders',
    excerpt: 'Essential risk management techniques that every trader should implement.',
    category: 'Risk Management',
    image: '/placeholder-blog.jpg',
    date: '2024-01-05'
  }
]
</script>

<template>
  <div class="min-h-screen bg-white">
    <!-- Sticky Header -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">
              Pip & Profit
            </h1>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex items-center space-x-8">
            <Link
              :href="route('home')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
            >
              Home
            </Link>
            <Link
              :href="route('courses.index')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
            >
              Courses
            </Link>
            <Link
              :href="route('pricing')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
            >
              Pricing
            </Link>
            <a
              href="#testimonials"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
            >
              Testimonials
            </a>
            <a
              href="#faq"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
            >
              FAQ
            </a>
            <Link
              :href="route('contact')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
            >
              Contact
            </Link>
          </div>

          <!-- CTA Buttons -->
          <div class="hidden md:flex items-center space-x-4">
            <template v-if="$page.props.auth.user">
              <Link
                :href="route('dashboard')"
                class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              >
                Dashboard
              </Link>
            </template>
            <template v-else>
              <Link
                :href="route('login')"
                class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              >
                Log in
              </Link>
              <Link
                :href="route('register')"
                class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:from-teal-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl"
              >
                Start Trading Now
              </Link>
            </template>
          </div>

          <!-- Mobile menu button -->
          <div class="md:hidden">
            <Button
              variant="ghost"
              size="sm"
              @click="toggleMobileMenu"
              class="p-2"
            >
              <Menu v-if="!isMobileMenuOpen" class="h-5 w-5" />
              <X v-else class="h-5 w-5" />
            </Button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <div v-if="isMobileMenuOpen" class="md:hidden py-4 border-t border-gray-200">
          <div class="flex flex-col space-y-4">
            <Link
              :href="route('home')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              @click="toggleMobileMenu"
            >
              Home
            </Link>
            <Link
              :href="route('courses.index')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              @click="toggleMobileMenu"
            >
              Courses
            </Link>
            <Link
              :href="route('pricing')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              @click="toggleMobileMenu"
            >
              Pricing
            </Link>
            <a
              href="#testimonials"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              @click="toggleMobileMenu"
            >
              Testimonials
            </a>
            <a
              href="#faq"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              @click="toggleMobileMenu"
            >
              FAQ
            </a>
            <Link
              :href="route('contact')"
              class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
              @click="toggleMobileMenu"
            >
              Contact
            </Link>
            <Separator />
            <template v-if="$page.props.auth.user">
              <Link
                :href="route('dashboard')"
                class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
                @click="toggleMobileMenu"
              >
                Dashboard
              </Link>
            </template>
            <template v-else>
              <Link
                :href="route('login')"
                class="text-gray-700 hover:text-teal-600 transition-colors font-medium"
                @click="toggleMobileMenu"
              >
                Log in
              </Link>
              <Link
                :href="route('register')"
                class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:from-teal-600 hover:to-blue-700 transition-all duration-200 text-center"
                @click="toggleMobileMenu"
              >
                Start Trading Now
              </Link>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-16 pb-20 overflow-hidden bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100">
      <div class="absolute inset-0 bg-gradient-to-r from-teal-600/10 to-blue-600/10"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
          <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
              <span class="block">Master Forex &</span>
              <span class="block bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">
                Volatility Trading
              </span>
            </h1>
            <p class="mt-6 text-lg text-gray-600 sm:text-xl">
              Learn to navigate the markets, manage risk, and trade confidently with our comprehensive courses designed by expert traders.
            </p>
            
            <!-- Stats -->
            <div class="mt-8 flex flex-wrap gap-4">
              <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-4 py-2">
                <Users class="h-5 w-5 text-teal-600" />
                <span class="text-sm font-medium text-gray-700">5K+ Students</span>
              </div>
              <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-4 py-2">
                <Star class="h-5 w-5 text-yellow-500" />
                <span class="text-sm font-medium text-gray-700">Top-rated Mentor</span>
              </div>
              <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-4 py-2">
                <TrendingUp class="h-5 w-5 text-green-600" />
                <span class="text-sm font-medium text-gray-700">Live Market Sessions</span>
              </div>
            </div>

            <!-- CTAs -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
              <Link
                :href="route('register')"
                class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl"
              >
                Get Started
                <ArrowRight class="ml-2 h-5 w-5" />
              </Link>
              <Button
                variant="outline"
                size="lg"
                @click="toggleVideoModal"
                class="inline-flex items-center justify-center px-8 py-4"
              >
                <Play class="mr-2 h-5 w-5" />
                Watch Intro Video
              </Button>
            </div>
          </div>
          
          <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
            <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
              <div class="relative block w-full bg-white rounded-lg overflow-hidden">
                <div class="bg-gradient-to-br from-teal-500 to-blue-600 p-8 text-white">
                  <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                      <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                      <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                      <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                    <span class="text-sm font-medium">Trading Platform</span>
                  </div>
                  <div class="space-y-2">
                    <div class="h-2 bg-white/20 rounded"></div>
                    <div class="h-2 bg-white/20 rounded w-3/4"></div>
                    <div class="h-2 bg-white/20 rounded w-1/2"></div>
                  </div>
                  <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="bg-white/10 rounded p-3">
                      <div class="text-xs text-white/70">EUR/USD</div>
                      <div class="text-lg font-bold text-green-400">1.0854</div>
                    </div>
                    <div class="bg-white/10 rounded p-3">
                      <div class="text-xs text-white/70">GBP/USD</div>
                      <div class="text-lg font-bold text-red-400">1.2647</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Course Categories -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            Your Trading Journey
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Structured learning paths designed to take you from beginner to expert trader
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <Card
            v-for="category in courseCategories"
            :key="category.title"
            class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"
          >
            <CardHeader>
              <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                  <Icon :name="category.icon" class="h-6 w-6 text-white" />
                </div>
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                  {{ category.lessons }} lessons
                </span>
              </div>
              <CardTitle class="text-lg">{{ category.title }}</CardTitle>
              <CardDescription>{{ category.description }}</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="flex items-center justify-between text-sm text-gray-500">
                <span>{{ category.hours }} hours</span>
                <ArrowRight class="h-4 w-4 group-hover:translate-x-1 transition-transform" />
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>

    <!-- Featured Courses -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            Featured Courses
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Most popular courses chosen by our community
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <Card
            v-for="course in featuredCourses"
            :key="course.title"
            class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
          >
            <div class="relative">
              <div class="aspect-video bg-gradient-to-br from-teal-500 to-blue-600 rounded-t-lg"></div>
              <span 
                :class="[
                  'absolute top-4 left-4 px-2 py-1 rounded text-xs font-medium',
                  course.level === 'Beginner' ? 'bg-green-100 text-green-800' : 
                  course.level === 'Intermediate' ? 'bg-yellow-100 text-yellow-800' : 
                  'bg-red-100 text-red-800'
                ]"
              >
                {{ course.level }}
              </span>
            </div>
            <CardHeader>
              <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ course.instructor }}</p>
                  <p class="text-xs text-gray-500">Instructor</p>
                </div>
              </div>
              <CardTitle class="text-lg">{{ course.title }}</CardTitle>
              <div class="flex items-center space-x-2">
                <div class="flex items-center">
                  <Star class="h-4 w-4 text-yellow-400 fill-current" />
                  <span class="ml-1 text-sm text-gray-600">{{ course.rating }}</span>
                </div>
                <span class="text-sm text-gray-500">({{ course.students }} students)</span>
              </div>
            </CardHeader>
            <CardContent>
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <span class="text-2xl font-bold text-teal-600">${{ course.price }}</span>
                  <span class="text-sm text-gray-500 line-through">${{ course.originalPrice }}</span>
                </div>
                <Button class="bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700">
                  Join Today
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>

    <!-- Value Proposition Banner -->
    <section class="py-20 bg-gray-900 relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-teal-600/20 to-blue-600/20"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="flex items-center justify-center mb-8">
          <TrendingUp class="h-12 w-12 text-teal-400 mr-4" />
          <h2 class="text-6xl font-bold text-white">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-400">
              PROFIT
            </span>
          </h2>
        </div>
        <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
          Transform your trading skills and start generating consistent profits with our proven strategies and expert guidance.
        </p>
        <Link
          :href="route('register')"
          class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-gray-900 bg-white hover:bg-gray-100 transition-all duration-200 shadow-lg hover:shadow-xl"
        >
          Start Your Journey
          <ArrowRight class="ml-2 h-5 w-5" />
        </Link>
      </div>
    </section>

    <!-- Feature Highlights -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
          <div>
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
              Why Choose Our Platform?
            </h2>
            <p class="mt-4 text-lg text-gray-600">
              We provide everything you need to succeed in the financial markets
            </p>
            
            <div class="mt-8 space-y-6">
              <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <BookOpen class="h-5 w-5 text-white" />
                  </div>
                </div>
                <div>
                  <h3 class="text-lg font-medium text-gray-900">Comprehensive Curriculum</h3>
                  <p class="mt-2 text-gray-600">From basics to advanced strategies, our courses cover everything you need to know.</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <Users class="h-5 w-5 text-white" />
                  </div>
                </div>
                <div>
                  <h3 class="text-lg font-medium text-gray-900">Expert Instructors</h3>
                  <p class="mt-2 text-gray-600">Learn from professional traders with years of experience in live markets.</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <Shield class="h-5 w-5 text-white" />
                  </div>
                </div>
                <div>
                  <h3 class="text-lg font-medium text-gray-900">Risk Management Focus</h3>
                  <p class="mt-2 text-gray-600">Learn proper risk management techniques to protect your capital.</p>
                </div>
              </div>
              
              <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <Clock class="h-5 w-5 text-white" />
                  </div>
                </div>
                <div>
                  <h3 class="text-lg font-medium text-gray-900">Lifetime Access</h3>
                  <p class="mt-2 text-gray-600">Once you purchase, you have lifetime access to all content and updates.</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-10 lg:mt-0">
            <div class="relative">
              <div class="aspect-video bg-gradient-to-br from-teal-500 to-blue-600 rounded-lg shadow-xl"></div>
              <div class="absolute inset-0 bg-gradient-to-br from-teal-600/20 to-blue-600/20 rounded-lg"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing Plans -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            Choose Your Plan
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Start with a plan that fits your learning goals
          </p>
          
          <!-- Pricing Toggle -->
          <div class="mt-8 flex items-center justify-center">
            <div class="bg-white rounded-lg p-1 shadow-sm">
              <button
                @click="activePricingToggle = 'monthly'"
                :class="[
                  'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                  activePricingToggle === 'monthly'
                    ? 'bg-teal-500 text-white'
                    : 'text-gray-600 hover:text-gray-900'
                ]"
              >
                Monthly
              </button>
              <button
                @click="activePricingToggle = 'annual'"
                :class="[
                  'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                  activePricingToggle === 'annual'
                    ? 'bg-teal-500 text-white'
                    : 'text-gray-600 hover:text-gray-900'
                ]"
              >
                Annual
                <span class="ml-1 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">Save 20%</span>
              </button>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card
            v-for="plan in pricingPlans"
            :key="plan.name"
            :class="[
              'relative transition-all duration-300 hover:shadow-xl hover:-translate-y-1',
              plan.popular ? 'ring-2 ring-teal-500' : ''
            ]"
          >
            <CardHeader>
              <div v-if="plan.popular" class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                <span class="bg-teal-500 text-white px-3 py-1 rounded-full text-xs font-medium">Most Popular</span>
              </div>
              <CardTitle class="text-xl">{{ plan.name }}</CardTitle>
              <CardDescription>{{ plan.description }}</CardDescription>
              <div class="flex items-baseline">
                <span class="text-4xl font-bold text-gray-900">${{ plan.price }}</span>
                <span class="text-gray-500 ml-1">/month</span>
              </div>
              <div class="text-sm text-gray-500 line-through">${{ plan.originalPrice }}/month</div>
            </CardHeader>
            <CardContent>
              <ul class="space-y-3">
                <li
                  v-for="feature in plan.features"
                  :key="feature"
                  class="flex items-start space-x-3"
                >
                  <Check class="h-5 w-5 text-teal-500 mt-0.5 flex-shrink-0" />
                  <span class="text-sm text-gray-600">{{ feature }}</span>
                </li>
              </ul>
              <Button
                :class="[
                  'w-full mt-6',
                  plan.popular
                    ? 'bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700'
                    : 'bg-gray-900 hover:bg-gray-800'
                ]"
              >
                Get Started
              </Button>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            What Our Students Say
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Join thousands of satisfied traders who have transformed their skills
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card
            v-for="testimonial in testimonials"
            :key="testimonial.name"
            class="hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
          >
            <CardContent class="pt-6">
              <div class="flex items-center mb-4">
                <div class="flex">
                  <Star
                    v-for="i in testimonial.rating"
                    :key="i"
                    class="h-5 w-5 text-yellow-400 fill-current"
                  />
                </div>
              </div>
              <blockquote class="text-gray-600 mb-6">
                "{{ testimonial.quote }}"
              </blockquote>
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                <div>
                  <p class="font-medium text-gray-900">{{ testimonial.name }}</p>
                  <p class="text-sm text-gray-500">{{ testimonial.role }}</p>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>

    <!-- Instructor CTA -->
    <section class="py-20 bg-gradient-to-r from-teal-600 to-blue-600">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white sm:text-4xl">
          Become a Mentor
        </h2>
        <p class="mt-4 text-xl text-teal-100 max-w-3xl mx-auto">
          Share your trading expertise and help others succeed in the financial markets
        </p>
        <Button
          size="lg"
          class="mt-8 bg-white text-teal-600 hover:bg-gray-100"
        >
          Apply Now
        </Button>
      </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            Frequently Asked Questions
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Everything you need to know about our courses and platform
          </p>
        </div>

        <div class="space-y-6">
          <Card
            v-for="(faq, index) in faqs"
            :key="index"
            class="hover:shadow-lg transition-shadow"
          >
            <CardHeader>
              <CardTitle class="text-lg">{{ faq.question }}</CardTitle>
            </CardHeader>
            <CardContent>
              <p class="text-gray-600">{{ faq.answer }}</p>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>

    <!-- Blog Section -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            Latest Insights
          </h2>
          <p class="mt-4 text-lg text-gray-600">
            Stay updated with the latest trading strategies and market insights
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <Card
            v-for="post in blogPosts"
            :key="post.title"
            class="group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer"
          >
            <div class="aspect-video bg-gradient-to-br from-teal-500 to-blue-600 rounded-t-lg"></div>
            <CardHeader>
              <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full w-fit">{{ post.category }}</span>
              <CardTitle class="text-lg group-hover:text-teal-600 transition-colors">
                {{ post.title }}
              </CardTitle>
              <CardDescription>{{ post.excerpt }}</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="flex items-center justify-between text-sm text-gray-500">
                <span>{{ new Date(post.date).toLocaleDateString() }}</span>
                <ArrowRight class="h-4 w-4 group-hover:translate-x-1 transition-transform" />
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- About -->
          <div>
            <h3 class="text-2xl font-bold bg-gradient-to-r from-teal-400 to-blue-400 bg-clip-text text-transparent mb-4">
              Pip & Profit
            </h3>
            <p class="text-gray-400 mb-4">
              Your trusted partner in Forex and volatility trading education. Learn from experts and master the markets.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-teal-400 transition-colors">
                <span class="sr-only">Twitter</span>
                <Icon name="twitter" class="h-5 w-5" />
              </a>
              <a href="#" class="text-gray-400 hover:text-teal-400 transition-colors">
                <span class="sr-only">YouTube</span>
                <Icon name="youtube" class="h-5 w-5" />
              </a>
              <a href="#" class="text-gray-400 hover:text-teal-400 transition-colors">
                <span class="sr-only">LinkedIn</span>
                <Icon name="linkedin" class="h-5 w-5" />
              </a>
            </div>
          </div>

          <!-- Links -->
          <div>
            <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
            <ul class="space-y-2">
              <li>
                <Link :href="route('courses.index')" class="text-gray-400 hover:text-teal-400 transition-colors">
                  Courses
                </Link>
              </li>
              <li>
                <Link :href="route('pricing')" class="text-gray-400 hover:text-teal-400 transition-colors">
                  Pricing
                </Link>
              </li>
              <li>
                <Link :href="route('contact')" class="text-gray-400 hover:text-teal-400 transition-colors">
                  Contact
                </Link>
              </li>
              <li>
                <a href="#testimonials" class="text-gray-400 hover:text-teal-400 transition-colors">
                  Testimonials
                </a>
              </li>
            </ul>
          </div>

          <!-- Newsletter -->
          <div>
            <h4 class="text-lg font-semibold text-white mb-4">Stay Updated</h4>
            <p class="text-gray-400 mb-4">
              Get the latest trading insights and course updates delivered to your inbox.
            </p>
            <div class="flex">
              <input
                type="email"
                placeholder="Enter your email"
                class="flex-1 px-4 py-2 rounded-l-lg border-0 bg-gray-800 text-white placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:outline-none"
              />
              <Button class="rounded-l-none bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700">
                Subscribe
              </Button>
            </div>
          </div>
        </div>

        <Separator class="my-8 bg-gray-800" />

        <!-- Sub-footer -->
        <div class="flex flex-col md:flex-row justify-between items-center">
          <p class="text-gray-400 text-sm">
            © 2024 Pip & Profit. All rights reserved.
          </p>
          <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="text-gray-400 hover:text-teal-400 transition-colors text-sm">
              Privacy Policy
            </a>
            <a href="#" class="text-gray-400 hover:text-teal-400 transition-colors text-sm">
              Terms of Service
            </a>
            <a href="#" class="text-gray-400 hover:text-teal-400 transition-colors text-sm">
              Cookie Policy
            </a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Video Modal -->
    <div
      v-if="isVideoModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
      @click="toggleVideoModal"
    >
      <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4" @click.stop>
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Introduction Video</h3>
          <Button variant="ghost" size="sm" @click="toggleVideoModal">
            <X class="h-5 w-5" />
          </Button>
        </div>
        <div class="aspect-video bg-gradient-to-br from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
          <Play class="h-16 w-16 text-white" />
        </div>
      </div>
    </div>
  </div>
</template>
