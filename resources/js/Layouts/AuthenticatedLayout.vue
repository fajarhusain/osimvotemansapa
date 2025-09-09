<script setup>
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link, usePage } from '@inertiajs/vue3'

// Heroicons
import {
  HomeIcon,
  UsersIcon,
  UserGroupIcon,
  ChartBarIcon,
  Cog6ToothIcon,
  ArrowLeftOnRectangleIcon,
  ChevronDownIcon,
  Bars3Icon,
} from '@heroicons/vue/24/outline'

const sidebarOpen = ref(true)
const pemilihOpen = ref(false)
const hasilSuaraOpen = ref(false)

const page = usePage()
</script>

<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside
      :class="[
        'bg-gradient-to-b from-green-700 via-emerald-700 to-green-900 text-white transition-all duration-300 shadow-lg',
        sidebarOpen ? 'w-64' : 'w-20'
      ]"
    >
      <!-- Logo + Toggle -->
      <div class="flex items-center justify-between px-4 py-5 border-b border-green-600/40">
        <Link :href="route('admin.dashboard')" class="flex items-center gap-3">
          <template v-if="page.props.sekolah && page.props.sekolah.logo">
            <img 
              :src="`/storage/${page.props.sekolah.logo}`" 
              alt="Logo Sekolah" 
              class="h-10 w-10 object-cover rounded-full ring-2 ring-white shadow-md" 
            />
          </template>
          <ApplicationLogo v-else class="h-10 w-auto text-white" />
          <span v-if="sidebarOpen && page.props.sekolah" class="font-bold text-white text-sm tracking-wide">
            {{ page.props.sekolah.nama_sekolah }}
          </span>
        </Link>
        <button
          @click="sidebarOpen = !sidebarOpen"
          class="text-gray-300 hover:text-white focus:outline-none"
        >
          <Bars3Icon class="h-6 w-6" />
        </button>
      </div>

      <!-- Menu -->
      <nav class="mt-4 space-y-1">
        
        <Link
          :href="route('admin.dashboard')"
          class="flex items-center px-4 py-2 rounded-md mx-2 transition hover:bg-green-600/50"
          :class="{ 'bg-green-600': route().current('admin.dashboard') }"
        >
          <HomeIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Dashboard</span>
        </Link>

        

        <Link
          :href="route('sekolah.index')"
          class="flex items-center px-4 py-2 rounded-md mx-2 transition hover:bg-green-600/50"
          :class="{ 'bg-green-600': route().current('sekolah.index') }"
        >
          <UsersIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Identitas Sekolah</span>
        </Link>

        <!-- Data Pemilih -->
        <button
          @click="pemilihOpen = !pemilihOpen"
          class="flex w-full items-center px-4 py-2 rounded-md mx-2 hover:bg-green-600/50 focus:outline-none transition"
        >
          <UsersIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3 flex-1 text-left">Data Pemilih</span>
          <ChevronDownIcon v-if="sidebarOpen" class="h-4 w-4 transition-transform"
            :class="{ 'rotate-180': pemilihOpen }" />
        </button>
        <div v-if="pemilihOpen && sidebarOpen" class="ml-10 space-y-1">
          <Link
            :href="route('pemilih.index')"
            class="block px-2 py-1 rounded hover:bg-green-600/40 transition"
            :class="{ 'font-bold text-green-200': route().current('pemilih.index') }"
          >
            Daftar Pemilih
          </Link>
          <Link
            :href="route('pemilih.import.form')"
            class="block px-2 py-1 rounded hover:bg-green-600/40 transition"
            :class="{ 'font-bold text-green-200': route().current('pemilih.import.form') }"
          >
            Import Data
          </Link>
        </div>

        <!-- Data Kandidat -->
        <Link
          :href="route('kandidat.index')"
          class="flex items-center px-4 py-2 rounded-md mx-2 transition hover:bg-green-600/50"
          :class="{ 'bg-green-600': route().current('kandidat.index') }"
        >
          <UserGroupIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Data Kandidat</span>
        </Link>

        <!-- Hasil Suara -->
        <button
          @click="hasilSuaraOpen = !hasilSuaraOpen"
          class="flex w-full items-center px-4 py-2 rounded-md mx-2 hover:bg-green-600/50 focus:outline-none transition"
        >
          <ChartBarIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3 flex-1 text-left">Hasil Suara</span>
          <ChevronDownIcon v-if="sidebarOpen" class="h-4 w-4 transition-transform"
            :class="{ 'rotate-180': hasilSuaraOpen }" />
        </button>
        <div v-if="hasilSuaraOpen && sidebarOpen" class="ml-10 space-y-1">
          <Link
            :href="route('rekap.index')"
            class="block px-2 py-1 rounded hover:bg-green-600/40 transition"
            :class="{ 'font-bold text-green-200': route().current('rekap.index') }"
          >
            Rekap Suara
          </Link>
        </div>

        <!-- Manajemen User -->
        <Link
          :href="route('users.index')"
          class="flex items-center px-4 py-2 rounded-md mx-2 transition hover:bg-green-600/50"
          :class="{ 'bg-green-600': route().current('users.index') }"
        >
          <Cog6ToothIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Manajemen Pengguna</span>
        </Link>
      </nav>
    </aside>

    <!-- Main -->
    <div class="flex flex-1 flex-col">
      <header class="flex items-center justify-between bg-white px-6 py-4 shadow">
        <h1 class="text-lg font-bold" v-if="page.props.sekolah && page.props.sekolah.nama_sekolah">
          PANEL ADMIN E-VOTE - {{ page.props.sekolah.nama_sekolah }}
        </h1>
        <h1 class="text-lg font-bold" v-else>E-Vote Mansapa</h1>

        <Link :href="route('admin.logout')" method="post" as="button" class="flex items-center text-red-600 hover:text-red-800">
          <ArrowLeftOnRectangleIcon class="h-5 w-5 mr-1" />
          Logout
        </Link>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>
