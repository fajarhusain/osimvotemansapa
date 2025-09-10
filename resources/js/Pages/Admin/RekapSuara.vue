<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'

const props = defineProps({
    hasilSuara: Array,
    totalSuara: Number,
    jumlahPemilih: Number,
    sudahMemilih: Number,
    belumMemilih: Number,
})

const colors = ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6']
const formatPercentage = (count, total) => total === 0 ? '0%' : ((count / total) * 100).toFixed(2)

// Ref canvas
const barChartRef = ref(null)
let barChartInstance = null

onMounted(() => {
  if (barChartRef.value) {
    barChartInstance = new Chart(barChartRef.value, {
      type: 'bar',
      data: {
        labels: props.hasilSuara.map(k => `${k.nama_ketua} & ${k.nama_wakil}`),
        datasets: [{
          label: 'Jumlah Suara',
          data: props.hasilSuara.map(k => k.suara_count),
          backgroundColor: props.hasilSuara.map((_, i) => colors[i % colors.length]),
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        plugins: { 
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} (${formatPercentage(ctx.parsed.y, props.totalSuara)}%)`
            }
          }
        },
        scales: {
          y: { 
            beginAtZero: true, 
            ticks: { stepSize: 1 } 
          }
        }
      }
    })
  }
})
const printPage = () => {
    window.print()
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Hasil Suara" />
    <div class="p-6 bg-white rounded-2xl shadow-lg">

      <h2 class="text-2xl font-bold text-gray-700 mb-6">📊 Hasil Suara</h2>

      <!-- Ringkasan Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow text-center">
          <div class="text-gray-500">Total Pemilih</div>
          <div class="text-3xl font-bold text-blue-600">{{ jumlahPemilih }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow text-center">
          <div class="text-gray-500">Sudah Memilih</div>
          <div class="text-3xl font-bold text-green-600">{{ sudahMemilih }}</div>
        </div>
        <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow text-center">
          <div class="text-gray-500">Belum Memilih</div>
          <div class="text-3xl font-bold text-red-600">{{ belumMemilih }}</div>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow text-center">
          <div class="text-gray-500">Total Suara Masuk</div>
          <div class="text-3xl font-bold text-purple-600">{{ totalSuara }}</div>
        </div>
      </div>

      <!-- Bar Chart -->
      <div class="p-4 mb-8 bg-white rounded-2xl shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Grafik Suara Kandidat</h3>
        <canvas ref="barChartRef" class="w-full max-h-64"></canvas>
      </div>

      <!-- Tabel Hasil Suara -->
      <div class="overflow-x-auto">
        <table class="w-full border text-sm">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="p-3 border text-center">#</th>
              <th class="p-3 border text-left">Nama Kandidat</th>
              <th class="p-3 border text-center">Jumlah Suara</th>
              <th class="p-3 border text-center">Persentase</th>
            </tr>
          </thead>
          <tbody>
  <tr 
    v-for="(kandidat, index) in hasilSuara" 
    :key="kandidat.id" 
    class="hover:bg-gray-50 transition"
  >
    <td class="p-3 border text-center">{{ index + 1 }}</td> <!-- nomor urut sesuai database -->
    <td class="p-3 border font-semibold">
      <div class="flex items-center gap-3">
        <img v-if="kandidat.foto" :src="`/storage/${kandidat.foto}`" class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 shadow-sm" />
        <span>{{ kandidat.nama_ketua }} & {{ kandidat.nama_wakil }}</span>
      </div>
    </td>
    <td class="p-3 border text-center font-bold text-lg">{{ kandidat.suara_count }}</td>
    <td class="p-3 border text-center">
      <div class="relative h-4 bg-gray-200 rounded-full overflow-hidden">
        <div 
          class="absolute top-0 left-0 h-4 rounded-full transition-all duration-700"
          :style="{ width: formatPercentage(kandidat.suara_count, totalSuara) + '%', backgroundColor: colors[index % colors.length] }"
        ></div>
      </div>
      <span class="text-xs font-semibold mt-1 inline-block">
        {{ formatPercentage(kandidat.suara_count, totalSuara) }}%
      </span>
    </td>
  </tr>
</tbody>


        </table>
      </div>

    </div>
  </AuthenticatedLayout>
</template>
