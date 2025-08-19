<template>
    <div class="max-w-md mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-bold mb-4">Login</h2>
        <form @submit.prevent="submit">
            <input v-model="form.email" type="email" placeholder="Email" class="input" />
            <input v-model="form.password" type="password" placeholder="Password" class="input" />
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({
    email: '',
    password: ''
})

const submit = async () => {
    try {
        const res = await axios.post('/login', form.value)
        localStorage.setItem('token', res.data.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`
        router.push('/dashboard')
    } catch (err) {
        alert('Login failed')
    }
}
</script>
