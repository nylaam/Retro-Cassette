<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CassetteSvg from '@/Components/CassetteSvg.vue'
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    color: 'coral',
    note: '',
})

function simpan() {
    form.post(route('cassettes.store'))
}
</script>

<template>
    <Head title="Kaset Baru" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-pixel text-sm">Kaset Baru</h2>
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
            </div>

            <div>
                <label>Catatan label (opsional)</label>
                <textarea v-model="form.note" maxlength="200" class="w-full rounded border p-2"></textarea>
            </div>

            <button :disabled="form.processing" class="rounded bg-ink px-4 py-2 text-cream">
                Simpan
            </button>
        </form>
    </AuthenticatedLayout>
</template>