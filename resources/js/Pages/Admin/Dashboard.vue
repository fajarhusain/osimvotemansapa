<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const props = defineProps({
  jumlahPemilih: Number,
  sudahMemilih: Number,
  belumMemilih: Number,
})

// Animasi angka sederhana
const animatedJumlah = ref(0)
const animatedSudah = ref(0)
const animatedBelum = ref(0)

function animateValue(target, to) {
  let start = 0
  const duration = 1000
  const stepTime = Math.max(Math.floor(duration / (to || 1)), 1)

  target.value = start // tampilkan 0 lebih dulu
  const timer = setInterval(() => {
    if (start < to) {
      start++
      target.value = start
    } else {
      clearInterval(timer)
    }
  }, stepTime)
}



onMounted(() => {
  animateValue(animatedJumlah, props.jumlahPemilih)
  animateValue(animatedSudah, props.sudahMemilih)
  animateValue(animatedBelum, props.belumMemilih)
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <h1 class="text-3xl font-extrabold mb-8 text-gray-800 tracking-tight">
      📊 Dashboard EVOTE MANSAPA 
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Jumlah Pemilih -->
      <div
        class="p-6 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 shadow hover:shadow-lg transition text-center"
      >
        <div class="text-gray-600 flex items-center justify-center gap-2 mb-2">
          <i class="fas fa-users text-green-500"></i>
          <span>Jumlah Pemilih</span>
        </div>
        <div class="text-4xl font-extrabold text-gray-800">
          {{ animatedJumlah }}
        </div>
      </div>

      <!-- Sudah Memilih -->
      <div
        class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 shadow hover:shadow-lg transition text-center"
      >
        <div class="text-gray-600 flex items-center justify-center gap-2 mb-2">
          <i class="fas fa-check-circle text-emerald-500"></i>
          <span>Sudah Memilih</span>
        </div>
        <div class="text-4xl font-extrabold text-emerald-600">
          {{ animatedSudah }}
        </div>
      </div>

      <!-- Belum Memilih -->
      <div
        class="p-6 rounded-2xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200 shadow hover:shadow-lg transition text-center"
      >
        <div class="text-gray-600 flex items-center justify-center gap-2 mb-2">
          <i class="fas fa-times-circle text-red-500"></i>
          <span>Belum Memilih</span>
        </div>
        <div class="text-4xl font-extrabold text-red-600">
          {{ animatedBelum }}
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
