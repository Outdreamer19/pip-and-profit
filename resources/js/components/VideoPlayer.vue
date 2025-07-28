<template>
  <div class="w-full">
    <div class="aspect-video bg-black rounded-lg overflow-hidden">
      <video
        v-if="videoUrl"
        ref="videoRef"
        class="w-full h-full"
        controls
        preload="metadata"
        @timeupdate="onTimeUpdate"
        @loadedmetadata="onLoadedMetadata"
        @ended="onVideoEnded"
      >
        <source :src="videoUrl" type="video/mp4" />
        Your browser does not support the video tag.
      </video>
      
      <div
        v-else
        class="w-full h-full flex items-center justify-center text-white"
      >
        <div class="text-center">
          <Icon name="video" class="w-16 h-16 mx-auto mb-4 text-gray-400" />
          <p class="text-lg font-medium">Video not available</p>
          <p class="text-sm text-gray-400">This lesson video is coming soon</p>
        </div>
      </div>
    </div>
    
    <!-- Video Controls -->
    <div v-if="videoUrl" class="mt-4 space-y-4">
      <!-- Progress Bar -->
      <div class="w-full bg-gray-200 rounded-full h-2">
        <div
          class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
          :style="{ width: `${progress}%` }"
        ></div>
      </div>
      
      <!-- Video Info -->
      <div class="flex items-center justify-between text-sm text-gray-600">
        <span>{{ formatTime(currentTime) }} / {{ formatTime(duration) }}</span>
        <div class="flex items-center space-x-2">
          <button
            @click="togglePlay"
            class="p-2 rounded-full hover:bg-gray-100"
          >
            <Icon :name="isPlaying ? 'pause' : 'play'" class="w-4 h-4" />
          </button>
          <button
            @click="toggleMute"
            class="p-2 rounded-full hover:bg-gray-100"
          >
            <Icon :name="isMuted ? 'volume-x' : 'volume-2'" class="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>
    
    <!-- Lesson Info -->
    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
      <h3 class="text-lg font-semibold text-gray-900 mb-2">
        {{ lessonTitle }}
      </h3>
      <p class="text-gray-600 mb-4">
        {{ lessonDescription }}
      </p>
      
      <!-- Lesson Progress -->
      <div class="flex items-center justify-between">
        <span class="text-sm text-gray-500">Lesson Progress</span>
        <span class="text-sm font-medium text-indigo-600">
          {{ Math.round(progress) }}% Complete
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import Icon from '@/components/Icon.vue'

interface Props {
  videoUrl: string | null
  lessonTitle: string
  lessonDescription: string
  lessonId: number
}

defineProps<Props>()

const videoRef = ref<HTMLVideoElement>()
const isPlaying = ref(false)
const isMuted = ref(false)
const currentTime = ref(0)
const duration = ref(0)
const progress = ref(0)

const formatTime = (seconds: number) => {
  const mins = Math.floor(seconds / 60)
  const secs = Math.floor(seconds % 60)
  return `${mins}:${secs.toString().padStart(2, '0')}`
}

const togglePlay = () => {
  if (!videoRef.value) return
  
  if (isPlaying.value) {
    videoRef.value.pause()
  } else {
    videoRef.value.play()
  }
}

const toggleMute = () => {
  if (!videoRef.value) return
  
  videoRef.value.muted = !videoRef.value.muted
  isMuted.value = videoRef.value.muted
}

const onTimeUpdate = () => {
  if (!videoRef.value) return
  
  currentTime.value = videoRef.value.currentTime
  progress.value = (currentTime.value / duration.value) * 100
}

const onLoadedMetadata = () => {
  if (!videoRef.value) return
  
  duration.value = videoRef.value.duration
}

const onVideoEnded = () => {
  isPlaying.value = false
  // Here you could mark the lesson as completed
  // emit('lessonCompleted', props.lessonId)
}

watch(() => videoRef.value?.paused, (paused) => {
  isPlaying.value = !paused
})

onMounted(() => {
  if (videoRef.value) {
    isMuted.value = videoRef.value.muted
  }
})
</script> 