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
const animatedJumlah = ref(props.jumlahPemilih)
const animatedSudah = ref(props.sudahMemilih)
const animatedBelum = ref(props.belumMemilih)

// Update props ketika reload
function updateData(newProps) {
  animatedJumlah.value = newProps.jumlahPemilih
  animatedSudah.value = newProps.sudahMemilih
  animatedBelum.value = newProps.belumMemilih
}

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
          data: [animatedSudah.value, animatedBelum.value],
          backgroundColor: ['#10B981', '#EF4444'],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
        },
      },
    },
  })

  // Polling tiap 5 detik
  setInterval(() => {
    router.reload({
      only: ['jumlahPemilih', 'sudahMemilih', 'belumMemilih'],
      onSuccess: (page) => {
        updateData(page.props)
      },
    })
  }, 5000)
})

// Update chart setiap data berubah
watch([animatedSudah, animatedBelum], () => {
  if (chartInstance) {
    chartInstance.data.datasets[0].data = [
      animatedSudah.value,
      animatedBelum.value,
    ]
    chartInstance.update()
  }
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <div class="mb-10 text-center">
      <h1
        class="text-4xl md:text-5xl font-extrabold mb-2 text-gray-800 tracking-tight"
      >
        📊 Dashboard EVOTE <span class="text-green-600">MANSAPA</span>
      </h1>
      <p class="text-gray-500">Pantau statistik pemilihan secara real-time</p>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
  <!-- Jumlah Pemilih -->
  <div
    class="relative group p-6 rounded-3xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 overflow-hidden"
  >
    <div
      class="absolute -top-6 -right-6 w-24 h-24 bg-green-200 opacity-20 rounded-full blur-2xl group-hover:opacity-30 transition"
    ></div>
    <div class="flex flex-col items-center text-center relative z-10">
      <div
        class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-2xl shadow mb-3"
      >
        <i class="fas fa-users"></i>
      </div>
      <span class="text-gray-600 text-lg font-medium">Jumlah Pemilih</span>
      <div class="text-5xl font-extrabold text-gray-800 mt-2">
        {{ animatedJumlah }}
      </div>
    </div>
  </div>

  <!-- Sudah Memilih -->
  <div
    class="relative group p-6 rounded-3xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 overflow-hidden"
  >
    <div
      class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-200 opacity-20 rounded-full blur-2xl group-hover:opacity-30 transition"
    ></div>
    <div class="flex flex-col items-center text-center relative z-10">
      <div
        class="w-14 h-14 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-2xl shadow mb-3"
      >
        <i class="fas fa-vote-yea"></i>
      </div>
      <span class="text-gray-600 text-lg font-medium">Sudah Memilih</span>
      <div class="text-5xl font-extrabold text-emerald-600 mt-2">
        {{ animatedSudah }}
      </div>
    </div>
  </div>

  <!-- Belum Memilih -->
  <div
    class="relative group p-6 rounded-3xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200 shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 overflow-hidden"
  >
    <div
      class="absolute -top-6 -right-6 w-24 h-24 bg-red-200 opacity-20 rounded-full blur-2xl group-hover:opacity-30 transition"
    ></div>
    <div class="flex flex-col items-center text-center relative z-10">
      <div
        class="w-14 h-14 flex items-center justify-center rounded-full bg-red-100 text-red-600 text-2xl shadow mb-3"
      >
        <i class="fas fa-user-clock"></i>
      </div>
      <span class="text-gray-600 text-lg font-medium">Belum Memilih</span>
      <div class="text-5xl font-extrabold text-red-600 mt-2">
        {{ animatedBelum }}
      </div>
    </div>
  </div>
</div>


    <!-- Widget Tambahan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Progress Partisipasi -->
      <div class="p-6 bg-white rounded-3xl shadow hover:shadow-xl transition">
        <h2 class="text-lg font-bold text-gray-800 mb-4">
          Progress Partisipasi
        </h2>
        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
          <div
            class="bg-green-500 h-6 text-xs font-medium text-white text-center p-0.5 leading-none"
            :style="{ width: (animatedSudah / animatedJumlah * 100) + '%' }"
          >
            {{ ((animatedSudah / animatedJumlah) * 100).toFixed(1) }}%
          </div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="p-6 bg-white rounded-3xl shadow hover:shadow-xl transition">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Distribusi Suara</h2>
        <canvas id="voteChart"></canvas>
      </div>
    </div>

    <!-- Info Box -->
    <div
      class="mt-10 p-6 bg-gradient-to-r from-indigo-50 to-indigo-100 border border-indigo-200 rounded-3xl shadow text-center"
    >
      <h2 class="text-xl font-bold text-indigo-700 mb-2">⏳ Waktu Pemilihan</h2>
      <p class="text-gray-700">
        Pemilihan akan ditutup pada
        <span class="font-semibold">10 September 2025, 17:00 WIB</span>
      </p>
    </div>
  </AuthenticatedLayout>
</template>
