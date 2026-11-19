<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CassetteSvg from '@/Components/CassetteSvg.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

// Kalau ada props "cassette" berarti halaman ini dipakai untuk edit
const props = defineProps({
    cassette: { type: Object, default: null },
})

const modeEdit = props.cassette !== null

const form = useForm({
    title: props.cassette?.title ?? '',
    color: props.cassette?.color ?? 'coral',
    note: props.cassette?.note ?? '',
})

function simpan() {
    if (modeEdit) {
        form.put(route('cassettes.update', props.cassette.id))
    } else {
        form.post(route('cassettes.store'))
    }
}
</script>

<template>
    <Head :title="modeEdit ? 'Edit Kaset' : 'Kaset Baru'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-pixel text-sm">{{ modeEdit ? 'Edit Kaset' : 'Kaset Baru' }}</h2>
        </template>

        <form @submit.prevent="simpan" class="mx-auto max-w-md space-y-4 p-6">
            <div class="mx-auto w-48">
                <CassetteSvg :color="form.color" :title="form.title" />
            </div>

            <div>
                <label>Judul (maks 40 karakter)</label>
                <input v-model="form.title" maxlength="40" class="w-full rounded border p-2" />
                <p v-if="form.errors.title" class="text-sm text-red-600">{{ form.errors.title }}</p>
            </div>

            <div>
                <label>Warna</label>
                <select v-model="form.color" class="w-full rounded border p-2">
                    <option value="coral">Koral</option>
                    <option value="teal">Teal</option>
                    <option value="purple">Ungu</option>
                    <option value="mustard">Kuning tua</option>
                </select>
                <p v-if="form.errors.color" class="text-sm text-red-600">{{ form.errors.color }}</p>
            </div>

            <div>
                <label>Catatan label (opsional)</label>
                <textarea v-model="form.note" maxlength="200" class="w-full rounded border p-2"></textarea>
                <p v-if="form.errors.note" class="text-sm text-red-600">{{ form.errors.note }}</p>
            </div>

            <div class="flex items-center gap-4">
                <button :disabled="form.processing" class="rounded bg-ink px-4 py-2 text-cream">
                    Simpan
                </button>
                <Link :href="route('shelf.index')" class="text-sm underline">Batal</Link>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
