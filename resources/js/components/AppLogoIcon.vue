<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="className" v-bind="$attrs" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 3v18h18"/>
        <path d="m9 9 3 3 3-3"/>
        <path d="m12 12 3 3 3-3"/>
        <path d="M6 6h3"/>
        <path d="M6 12h3"/>
        <path d="M6 18h3"/>
    </svg>
</template>
