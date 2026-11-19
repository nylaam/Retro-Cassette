<script setup>
const props = defineProps({
    color: { type: String, default: 'coral' },
    title: { type: String, default: '' },
})

const warna = {
    coral: '#E8725C',
    teal: '#2A9D8F',
    purple: '#7B5EA7',
    mustard: '#D4A017',
}
</script>

<template>
    <svg viewBox="0 0 200 130" class="w-full">
        <!-- badan kaset -->
        <rect x="5" y="5" width="190" height="120" rx="10" :fill="warna[color]" />
        <!-- label -->
        <rect x="25" y="15" width="150" height="45" rx="4" fill="#F5EBD7" />
        <text x="100" y="43" text-anchor="middle" font-size="12" fill="#2B2B2B">
            {{ title }}
        </text>
        <!-- dua roda pita -->
        <circle cx="65" cy="90" r="16" fill="#2B2B2B" />
        <circle cx="135" cy="90" r="16" fill="#2B2B2B" />
        <circle cx="65" cy="90" r="6" fill="#F5EBD7" />
        <circle cx="135" cy="90" r="6" fill="#F5EBD7" />
    </svg>
</template>