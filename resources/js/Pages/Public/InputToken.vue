<script setup>
import { useForm, Head } from '@inertiajs/vue3';

defineProps({
    status: String,
    error: String,
    sekolah: Object,
});

const form = useForm({
    token: '',
});

const submit = () => {
    form.post(route('public.submit'));
};
</script>

<template>
    <Head title="E-Voting MAN 1 PATI" />

    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-700 via-emerald-600 to-green-400 p-4">
        <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-2xl text-center relative overflow-hidden">

            <!-- Dekorasi background -->
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-green-200 rounded-full blur-2xl opacity-30"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-300 rounded-full blur-2xl opacity-30"></div>

            <!-- Judul dengan logo MAN 1 Pati -->
            <div class="flex flex-col sm:flex-row items-center justify-center mb-2 space-y-2 sm:space-y-0 sm:space-x-3">
                <img 
                    src="/images/logomansapa.png" 
                    alt="Logo MAN 1 Pati" 
                    class="h-16 w-16 sm:h-12 sm:w-12 object-contain rounded-full shadow-md"
                />
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-green-700 to-emerald-400 bg-clip-text text-transparent tracking-tight">
                    🗳️ E-Voting
                </h1>
            </div>

            <h2 class="text-lg font-semibold text-gray-700 mb-6">
                {{ sekolah?.nama ?? 'MAN 1 PATI' }}
            </h2>

            <!-- Deskripsi -->
            <p class="text-gray-600 mb-6 leading-relaxed">
                Masukkan <span class="font-semibold text-green-700">token</span> yang Anda miliki untuk memulai pemilihan Ketua OSIM
            </p>

            <!-- Status & Error -->
            <div v-if="status" class="mb-4 text-green-700 font-medium bg-green-100 p-3 rounded-lg border border-green-300 animate-bounce">
                {{ status }}
            </div>
            <div v-if="error" class="mb-4 text-red-700 font-medium bg-red-100 p-3 rounded-lg border border-red-300 animate-shake">
                {{ error }}
            </div>

            <!-- Form Token -->
            <form @submit.prevent="submit" class="space-y-4">
                <input
                    v-model="form.token"
                    type="text"
                    placeholder="Masukkan Token Anda"
                    maxlength="8"
                    class="border-2 border-green-300 w-full p-3 rounded-2xl focus:ring-4 focus:ring-green-500/40 focus:border-green-500 text-center uppercase text-xl tracking-widest font-mono transition-all"
                />
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-700 to-emerald-500 text-white font-bold py-3 rounded-2xl hover:scale-105 transform transition duration-300 shadow-lg"
                    :disabled="form.processing"
                >
                    Mulai Memilih
                </button>
            </form>

            <!-- Footer -->
            <p class="text-sm text-gray-500 text-center mt-6">
                © {{ new Date().getFullYear() }} {{ sekolah?.nama ?? 'MANSAPA' }} <br/> 
                Dibuat dengan <span class="text-red-500">❤</span> oleh 
                <a href="https://patitech.id" target="_blank" class="font-semibold text-green-600 hover:underline">
                    PATITECH.ID
                </a>
            </p>

        </div>
    </div>
</template>
