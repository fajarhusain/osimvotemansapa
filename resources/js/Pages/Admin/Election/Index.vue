<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  election: Object
})

const page = usePage()
const flashMessage = ref(page.props.flash?.success || null) // simpan flash ke state lokal

const form = useForm({
  name: props.election?.name || 'Pemilihan OSIS MANSAPA',
  start_time: props.election?.start_time || '',
  end_time: props.election?.end_time || ''
})

const submit = () => {
  form.post(route('election.store'))
}

// 🔔 Watch perubahan flash dari inertia
watch(
  () => page.props.flash?.success,
  (newVal) => {
    if (newVal) {
      flashMessage.value = newVal
      setTimeout(() => {
        flashMessage.value = null // otomatis hilang setelah 3 detik
      }, 3000)
    }
  },
  { immediate: true }
)
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Pengaturan Pemilihan" />

    <div class="max-w-3xl mx-auto bg-white shadow rounded-xl p-6 relative">
      <h1 class="text-2xl font-bold mb-6">⚙️ Pengaturan Pemilihan</h1>

      <!-- ✅ Toast Notifikasi -->
      <transition name="fade">
        <div
          v-if="flashMessage"
          class="absolute top-0 right-0 mt-4 mr-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg"
        >
          ✅ {{ flashMessage }}
        </div>
      </transition>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <label class="block text-gray-700 font-medium mb-2">Nama Pemilihan</label>
          <input v-model="form.name" type="text" class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-2">Waktu Mulai</label>
          <input v-model="form.start_time" type="datetime-local" class="w-full border rounded-lg px-3 py-2" />
        </div>

        <div v-if="$page.props.flash?.success" 
     class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-300">
  ✅ {{ $page.props.flash.success }}
</div>


        <div>
          <label class="block text-gray-700 font-medium mb-2">Waktu Berakhir</label>
          <input v-model="form.end_time" type="datetime-local" class="w-full border rounded-lg px-3 py-2" />
        </div>

        <button
          type="submit"
          class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
        >
          Simpan Pengaturan
        </button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<style>
/* Animasi fade sederhana */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
