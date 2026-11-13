<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CassetteSvg from '@/Components/CassetteSvg.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({ cassettes: Array })
</script>

<template>
    <Head title="Rak Kaset" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-pixel text-sm">Rak Kaset Saya</h2>
        </template>

        <div class="mx-auto max-w-5xl bg-cream p-6">
            <Link :href="route('cassettes.create')" class="font-pixel text-xs underline">
                + Kaset baru
            </Link>

            <p v-if="cassettes.length === 0" class="mt-6">
                Rak masih kosong. Bikin kaset pertamamu!
            </p>

            <div class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-3">
                <div v-for="kaset in cassettes" :key="kaset.id">
                    <CassetteSvg :color="kaset.color" :title="kaset.title" />
                    <p class="mt-1 text-sm">{{ kaset.tracks_count }} lagu</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>