<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  sekolah: Object,
})

const form = ref({
  username: '',
  password: ''
})

function submit() {
  router.post('/admin/login', form.value)
}
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-300 via-green-100 to-green-50 relative overflow-hidden">
    <!-- Background Circle -->
    <div class="absolute -top-32 -left-32 w-72 h-72 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse delay-2000"></div>

    <!-- Card -->
    <div class="relative w-full max-w-md bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-green-100 transform hover:scale-[1.02] transition duration-300">
      
      <!-- Logo Sekolah -->
      <div class="flex justify-center mb-6">
        <img 
          v-if="sekolah && sekolah.logo" 
          :src="`/storage/${sekolah.logo}`" 
          alt="Logo Sekolah" 
          class="h-20 w-auto object-contain drop-shadow-md hover:scale-105 transition-transform duration-300"
        />
      </div>

      <!-- Judul -->
      <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-8 tracking-tight">
        Selamat Datang 👋
      </h1>

      <!-- Username -->
      <div class="relative mb-4">
        <span class="absolute inset-y-0 left-3 flex items-center text-green-500">
          <i class="fas fa-user"></i>
        </span>
        <input 
          v-model="form.username" 
          placeholder="Username"
          class="border border-gray-200 w-full pl-10 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 shadow-sm transition"
        />
      </div>

      <!-- Password -->
      <div class="relative mb-6">
        <span class="absolute inset-y-0 left-3 flex items-center text-green-500">
          <i class="fas fa-lock"></i>
        </span>
        <input 
          type="password" 
          v-model="form.password" 
          placeholder="Password"
          class="border border-gray-200 w-full pl-10 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 shadow-sm transition"
        />
      </div>

      <!-- Tombol -->
      <button 
        @click="submit"
        class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 transition duration-300 ease-in-out text-white px-4 py-3 w-full rounded-xl font-semibold shadow-lg hover:shadow-green-200"
      >
        Login
      </button>

      <!-- Tambahan -->
<p class="text-sm text-gray-500 text-center mt-6">
  © {{ new Date().getFullYear() }} {{ sekolah?.nama ?? 'MAN 1 PATI' }} <br/> 
  Dibuat dengan <span class="text-red-500">❤</span> oleh 
  <a 
    href="https://patitech.id" 
    target="_blank" 
    class="text-green-600 font-semibold hover:underline hover:text-green-700 transition"
  >
    PATITECH.ID
  </a>
</p>

    </div>
  </div>
</template>
