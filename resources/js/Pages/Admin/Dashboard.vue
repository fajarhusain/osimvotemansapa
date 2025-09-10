<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, onMounted, watch } from 'vue'
import Chart from 'chart.js/auto'

// Props dari backend
const props = defineProps({
  jumlahPemilih: Number,
  sudahMemilih: Number,
  belumMemilih: Number,
})

// State reactive
const jumlahPemilih = ref(props.jumlahPemilih)
const sudahMemilih = ref(props.sudahMemilih)
const belumMemilih = ref(props.belumMemilih)

// Chart instance
let chartInstance = null

onMounted(() => {
  const ctx = document.getElementById('voteChart')
  chartInstance = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Sudah Memilih', 'Belum Memilih'],
      datasets: [
        {
          data: [sudahMemilih.value, belumMemilih.value],
          backgroundColor: ['#10B981', '#EF4444'],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' },
      },
    },
  })

  setInterval(async () => {
    await router.reload({
      only: ['jumlahPemilih', 'sudahMemilih', 'belumMemilih'],
      preserveState: true,
      onSuccess: (page) => {
        jumlahPemilih.value = page.props.jumlahPemilih
        sudahMemilih.value = page.props.sudahMemilih
        belumMemilih.value = page.props.belumMemilih
      },
    })
  }, 5000)
})

watch([sudahMemilih, belumMemilih], () => {
  if (chartInstance) {
    chartInstance.data.datasets[0].data = [sudahMemilih.value, belumMemilih.value]
    chartInstance.update()
  }
})

// Countdown Timer
const endTime = new Date("2025-09-10T17:00:00").getTime()
const remainingTime = ref("")

function updateCountdown() {
  const now = new Date().getTime()
  const distance = endTime - now

  if (distance <= 0) {
    remainingTime.value = "⏳ Pemilihan sudah ditutup!"
    return
  }

  const hours = Math.floor(distance / (1000 * 60 * 60))
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
  const seconds = Math.floor((distance % (1000 * 60)) / 1000)

  remainingTime.value = `${hours}h ${minutes}m ${seconds}s`
}

onMounted(() => {
  updateCountdown()
  setInterval(updateCountdown, 1000)
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <div class="flex flex-col min-h-screen">

      <!-- Konten utama fleksibel -->
      <main class="flex-1 px-4 py-2 flex flex-col items-center justify-center">

        <!-- Header -->
        <div class="flex flex-col items-center space-y-1 mb-4">
          <img src="/images/logomansapa.png" alt="Logo MAN 1 Pati" class="h-16 w-16 rounded-full shadow-md"/>
          <h1 class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-green-700 to-emerald-400 bg-clip-text text-transparent text-center">
            E-Voting
          </h1>
          <h1 class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-green-700 to-emerald-400 bg-clip-text text-transparent text-center">
            MAN 1 PATI
          </h1>
          <p class="text-gray-500 text-xs md:text-sm mt-1">Pantau statistik pemilihan real-time</p>
        </div>

        <!-- Statistik Ringkas -->
        <div class="flex justify-center gap-3 mb-4 w-full max-w-4xl">
          <div class="flex-1 px-3 py-2 rounded-xl shadow bg-gradient-to-br from-green-50 to-green-100 flex flex-col items-center text-xs md:text-sm">
            <i class="fas fa-users text-green-600 text-2xl md:text-3xl mb-1"></i>
            <h2 class="font-semibold text-green-700">Jumlah Pemilih</h2>
            <p class="text-4xl md:text-5xl font-extrabold text-green-700 mt-1">{{ jumlahPemilih }}</p>
          </div>
          <div class="flex-1 px-3 py-2 rounded-xl shadow bg-gradient-to-br from-emerald-50 to-emerald-100 flex flex-col items-center text-xs md:text-sm">
            <i class="fas fa-vote-yea text-emerald-600 text-2xl md:text-3xl mb-1"></i>
            <h2 class="font-semibold text-emerald-700">Sudah Memilih</h2>
            <p class="text-4xl md:text-5xl font-extrabold text-emerald-700 mt-1">{{ sudahMemilih }}</p>
          </div>
          <div class="flex-1 px-3 py-2 rounded-xl shadow bg-gradient-to-br from-red-50 to-red-100 flex flex-col items-center text-xs md:text-sm">
            <i class="fas fa-user-clock text-red-600 text-2xl md:text-3xl mb-1"></i>
            <h2 class="font-semibold text-red-700">Belum Memilih</h2>
            <p class="text-4xl md:text-5xl font-extrabold text-red-700 mt-1">{{ belumMemilih }}</p>
          </div>
        </div>

        <!-- Distribusi Suara -->
        <div class="p-2 bg-white rounded-3xl shadow flex flex-col justify-center items-center w-full max-w-2xl mb-4">
          <h2 class="text-sm md:text-base font-bold text-gray-800 mb-1">Distribusi Suara</h2>
          <canvas id="voteChart" class="w-full max-h-36"></canvas>
        </div>

        <!-- Progress Partisipasi -->
        <div class="w-full max-w-2xl mb-4">
          <div class="flex items-center justify-between mb-1 text-xs md:text-sm">
            <h2 class="font-semibold text-gray-700">Progress Partisipasi</h2>
            <span class="font-bold text-green-600">
              {{ ((sudahMemilih / jumlahPemilih) * 100).toFixed(1) }}%
            </span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2 md:h-3 overflow-hidden">
            <div class="bg-green-500 h-2 md:h-3 transition-all duration-500"
              :style="{ width: (sudahMemilih / jumlahPemilih * 100) + '%' }"></div>
          </div>
        </div>

      </main>

      <!-- Footer floating di bawah -->
      <footer class="fixed bottom-0 left-0 w-full bg-gray-100 bg-opacity-90 text-center py-2 text-xs md:text-sm shadow-md border-t border-gray-300">
        <p>&copy; 2025 PATITECH SOLUTION. All rights reserved.</p>
      </footer>

    </div>
  </AuthenticatedLayout>
</template>

