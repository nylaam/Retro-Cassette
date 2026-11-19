<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CassetteSvg from '@/Components/CassetteSvg.vue'
import DangerButton from '@/Components/DangerButton.vue'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({ cassettes: Array })

// Dialog konfirmasi hapus
const dialogHapusTerbuka = ref(false)
const kasetTerpilih = ref(null)
const sedangMenghapus = ref(false)

function tanyaHapus(kaset) {
    kasetTerpilih.value = kaset
    dialogHapusTerbuka.value = true
}

function batalHapus() {
    dialogHapusTerbuka.value = false
}

function hapus() {
    router.delete(route('cassettes.destroy', kasetTerpilih.value.id), {
        preserveScroll: true,
        onStart: () => (sedangMenghapus.value = true),
        onSuccess: () => batalHapus(),
        onFinish: () => (sedangMenghapus.value = false),
    })
}
</script>

<template>
    <Head title="Rak Kaset" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-pixel text-sm">Rak Kaset Saya</h2>
        </template>

        <div class="mx-auto max-w-5xl bg-cream p-6">
            <p v-if="cassettes.length === 0" class="mb-6">
                Rak masih kosong. Bikin kaset pertamamu!
            </p>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                <div v-for="kaset in cassettes" :key="kaset.id" class="space-y-1">
                    <CassetteSvg :color="kaset.color" :title="kaset.title" />
                    <p class="text-sm">{{ kaset.tracks_count }} lagu</p>

                    <div class="flex gap-4 text-sm">
                        <Link :href="route('cassettes.edit', kaset.id)" class="underline">
                            Edit
                        </Link>
                        <button
                            type="button"
                            class="text-red-600 underline"
                            :aria-label="`Hapus kaset ${kaset.title}`"
                            @click="tanyaHapus(kaset)"
                        >
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- ubin tambah kaset -->
                <Link
                    :href="route('cassettes.create')"
                    class="flex aspect-[200/130] items-center justify-center rounded-lg border-2 border-dashed border-ink font-pixel text-xs"
                >
                    + Kaset baru
                </Link>
            </div>
        </div>

        <Modal :show="dialogHapusTerbuka" max-width="md" @close="batalHapus">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Hapus kaset ini?</h2>

                <p class="mt-1 text-sm text-gray-600">
                    Kaset "{{ kasetTerpilih?.title }}" dan {{ kasetTerpilih?.tracks_count }} lagu
                    di dalamnya akan dihapus permanen.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="batalHapus">Batal</SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': sedangMenghapus }"
                        :disabled="sedangMenghapus"
                        @click="hapus"
                    >
                        Hapus
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
