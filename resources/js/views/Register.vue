<template>
    <div class="relative min-h-screen flex items-center justify-center bg-white overflow-hidden">

        <div class="absolute top-10 left-10 w-40 h-40 bg-purple-600 rounded-t-lg opacity-40 animate-float1"></div>
        <div class="absolute bottom-20 right-20 w-56 h-56 bg-indigo-600 rounded-bl-2xl opacity-50 animate-float2"></div>
        <svg class="absolute top-0 left-0 w-[600px] h-[600px] -translate-x-1/4 -translate-y-1/4 opacity-30 animate-blob1" viewBox="0 0 600 600">
            <path fill="#a78bfa" d="M421,342Q384,444,280,423Q176,402,134,313Q92,224,158,138Q224,52,321,73Q418,94,440,203Q462,312,421,342Z"/>
        </svg>

        <svg class="absolute bottom-0 right-0 w-[700px] h-[700px] translate-x-1/4 translate-y-1/4 opacity-30 animate-blob2" viewBox="0 0 600 600">
            <path fill="#6366f1" d="M429,329Q401,408,319,402Q237,396,179,322Q121,248,147,167Q173,86,261,82Q349,78,403,145Q457,212,429,329Z"/>
        </svg>
        <form
            @submit.prevent="handleRegister"
            class="relative z-10 bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md transform transition-transform duration-500 hover:scale-105 animate__animated animate__fadeIn"
        >
            <h2 class="text-3xl font-extrabold mb-8 text-center text-gray-800">Create Account</h2>

            <div v-if="error" class="mb-4 text-red-600 text-sm">
                <div v-for="(errMsg, index) in error" :key="index">{{ errMsg }}</div>
            </div>

            <div v-if="success" class="mb-4 text-green-600 text-sm font-semibold">
                Registration successful!
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 mb-1">Name</label>
                <input type="text" v-model="form.name" placeholder="Your name"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400 transition duration-300">
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" v-model="form.email" placeholder="you@example.com"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400 transition duration-300">
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 mb-1">Password</label>
                <input type="password" v-model="form.password" placeholder="Password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400 transition duration-300">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Confirm Password</label>
                <input type="password" v-model="form.password_confirmation" placeholder="Confirm Password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400 transition duration-300">
            </div>

            <button type="submit"
                    class="w-full bg-purple-600 text-white font-bold py-3 rounded-lg hover:bg-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                Register
            </button>

            <p class="mt-6 text-center text-gray-500 text-sm">
                Already have an account?
                <router-link to="/login" class="text-purple-600 font-semibold hover:underline">
                    Login here
                </router-link>
            </p>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: { name: '', email: '', password: '', password_confirmation: '' },
            error: null,
            success: false,
        };
    },
    methods: {
        async handleRegister() {
            this.error = null;
            this.success = false;
            try {
                await axios.post('http://mirshood-invoice.loc/api/register', this.form);
                this.success = true;
            } catch (err) {
                const response = err.response?.data;
                if (response?.errors) {
                    this.error = Object.values(response.errors).flat();
                } else {
                    this.error = [response?.message || 'Registration failed'];
                }
            }
        },
    },
};
</script>

<style>
@import 'animate.css';

/* Floating shapes animations */
@keyframes float1 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    50% { transform: translateY(-30px) translateX(30px) rotate(45deg); }
}
@keyframes float2 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    50% { transform: translateY(40px) translateX(-40px) rotate(-45deg); }
}
@keyframes float3 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    50% { transform: translateY(40px) translateX(-40px) rotate(-45deg); }
}
@keyframes float4 {
    0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
    50% { transform: translateY(40px) translateX(-40px) rotate(-45deg); }
}

.animate-float1 { animation: float1 8s ease-in-out infinite; }
.animate-blob1 { animation: float3 6s ease-in-out infinite; }
.animate-blob2 { animation: float4 6s ease-in-out infinite; }
.animate-float2 { animation: float2 8s ease-in-out infinite; }

</style>
