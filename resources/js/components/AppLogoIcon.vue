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
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-castle-icon lucide-castle" v-bind="$attrs">
        <path d="M22 20v-9H2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2Z"/>
        <path d="M18 11V4H6v7"/>
        <path d="M15 22v-4a3 3 0 0 0-3-3a3 3 0 0 0-3 3v4"/>
        <path d="M22 11V9"/>
        <path d="M2 11V9"/>
        <path d="M6 4V2"/>
        <path d="M18 4V2"/>
        <path d="M10 4V2"/>
        <path d="M14 4V2"/>
    </svg>
</template>
