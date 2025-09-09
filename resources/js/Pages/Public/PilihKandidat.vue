<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
  kandidat: Object,
});

const form = useForm({
  kandidat_id: null,
});

const konfirmasiPilih = (kandidat) => {
  Swal.fire({
    title: 'Konfirmasi Pilihan',
    html: `
      <div class="text-lg font-semibold text-gray-800">
        ${kandidat.nama_ketua} & ${kandidat.nama_wakil}
      </div>
      <small class="text-red-600">Pilihan tidak dapat diubah setelah dikonfirmasi.</small>
    `,
    imageUrl: kandidat.foto ? `/storage/${kandidat.foto}` : null,
    imageWidth: 150,
    imageHeight: 150,
    imageAlt: 'Foto Kandidat',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Pilih!',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#16a34a',
    cancelButtonColor: '#d33',
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      form.kandidat_id = kandidat.id;
      form.post(route('public.store-suara'));
    }
  });
};
</script>

<template>
  <Head title="Pilih Kandidat" />

  <!-- Wrapper utama -->
  <div
    class="min-h-screen flex flex-col bg-gradient-to-br from-green-50 via-emerald-50 to-white relative"
  >
    <!-- Ornamen background -->
    <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-r from-green-600 to-emerald-500 clip-path-wave"></div>

    <!-- Konten -->
    <div class="flex-1 py-16 px-6 flex flex-col items-center relative z-10">
      <!-- Header -->
<header
  class="relative text-center py-16 px-6 overflow-hidden bg-gradient-to-r from-green-700 via-emerald-600 to-green-500"
>
  <!-- Wave animasi -->
  <div
    class="absolute bottom-0 left-0 w-full h-20 bg-white opacity-80 wave-animation"
  ></div>

  <!-- Judul -->
  <h1
    class="relative z-10 text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg tracking-wide animate-fade-in"
  >
    🏆 E-Voting OSIS <br />
    <span
      class="bg-gradient-to-r from-yellow-300 via-white to-yellow-300 bg-clip-text text-transparent"
    >
      MAN 1 PATI
    </span>
  </h1>

  <!-- Subjudul -->
  <p
    class="relative z-10 mt-4 text-lg md:text-xl text-green-100 font-medium drop-shadow"
  >
    Pemilihan Ketua & Wakil Ketua Periode <span class="font-bold">2025/2026</span>
  </p>

  <!-- Garis hias -->
  <div class="relative z-10 mt-6 flex justify-center gap-2">
    <span class="h-1 w-12 bg-yellow-300 rounded-full"></span>
    <span class="h-1 w-12 bg-white rounded-full"></span>
    <span class="h-1 w-12 bg-yellow-300 rounded-full"></span>
  </div>
</header>


      <!-- Grid Kandidat -->
      <!-- Grid Kandidat -->
<div
  class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 w-full max-w-6xl"
>
  <div
    v-for="kandidatItem in kandidat"
    :key="kandidatItem.id"
    class="group rounded-3xl bg-white/70 backdrop-blur-lg border border-green-200 shadow-lg hover:shadow-2xl hover:border-green-500 transform hover:-translate-y-3 transition-all duration-500 flex flex-col overflow-hidden"
  >
    <!-- Foto -->
    <div class="flex justify-center mt-8 relative">
      <img
        v-if="kandidatItem.foto"
        :src="`/storage/${kandidatItem.foto}`"
        alt="Foto Kandidat"
        class="w-40 h-40 object-cover rounded-full ring-4 ring-green-500 shadow-xl group-hover:scale-110 group-hover:animate-pulse transition-transform duration-500"
      />
      <div
        v-else
        class="w-40 h-40 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-semibold text-sm"
      >
        Tidak ada foto
      </div>
    </div>

    <!-- Nama -->
    <div class="px-6 py-6 text-center flex-1">
      <h2
        class="text-2xl font-extrabold text-gray-800 group-hover:text-green-700 transition-colors"
      >
        {{ kandidatItem.nama_ketua }}
        <span class="text-green-600">&</span>
        {{ kandidatItem.nama_wakil }}
      </h2>
      <p class="text-sm text-gray-500 mt-2 opacity-80">
        Calon Ketua & Wakil Ketua OSIS
      </p>
    </div>

    <!-- Tombol -->
    <div class="w-full px-6 pb-8 mt-auto">
      <button
        @click="konfirmasiPilih(kandidatItem)"
        class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-bold rounded-xl shadow-md hover:shadow-green-500/50 hover:scale-105 transition-all duration-300"
      >
        Pilih Kandidat Ini ✨
      </button>
    </div>
  </div>
</div>

    </div>

    <!-- Footer -->
    <footer class="w-full bg-green-800 text-white py-6 mt-12 relative z-10">
      <div
        class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 border-t border-green-600 pt-4"
      >
        <!-- Kiri -->
        <div class="text-center md:text-left">
          <h2 class="font-bold text-lg">E-Voting OSIS MAN 1 PATI</h2>
          <p class="text-sm text-green-200">
            Powered by
            <a
              href="https://patitech.id"
              target="_blank"
              class="font-semibold hover:underline hover:text-yellow-300 transition-colors"
            >
              PATITECH.ID 🔗
            </a>
          </p>
        </div>

        <!-- Tengah -->
        <div class="hidden md:flex items-center gap-6 text-sm">
          <a
            href="https://patitech.id"
            target="_blank"
            class="hover:underline hover:text-yellow-300"
          >
            🌐 Website
          </a>
          <a
            href="mailto:info@patitech.id"
            class="hover:underline hover:text-yellow-300"
          >
            ✉️ Email
          </a>
          <a
            href="https://wa.me/6285255559216"
            target="_blank"
            class="hover:underline hover:text-yellow-300"
          >
            📱 WhatsApp
          </a>
        </div>

        <!-- Kanan -->
        <div class="text-center md:text-right text-sm text-green-200">
          © {{ new Date().getFullYear() }} PATITECH.ID
          <span class="block md:inline"> • All Rights Reserved</span>
        </div>
      </div>
    </footer>
  </div>
</template>

<style>
/* Wave effect untuk header */
/* Animasi wave bergerak */
.wave-animation {
  clip-path: polygon(0 40%, 25% 60%, 50% 40%, 75% 60%, 100% 40%, 100% 100%, 0 100%);
  animation: waveMove 6s infinite linear;
}

@keyframes waveMove {
  0% {
    clip-path: polygon(0 40%, 25% 60%, 50% 40%, 75% 60%, 100% 40%, 100% 100%, 0 100%);
  }
  50% {
    clip-path: polygon(0 60%, 25% 40%, 50% 60%, 75% 40%, 100% 60%, 100% 100%, 0 100%);
  }
  100% {
    clip-path: polygon(0 40%, 25% 60%, 50% 40%, 75% 60%, 100% 40%, 100% 100%, 0 100%);
  }
}

/* Animasi fade-in sederhana */
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 1s ease-in-out;
}

</style>
