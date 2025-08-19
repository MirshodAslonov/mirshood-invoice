<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <p>Welcome, {{ user?.name }}</p>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'

const user = ref(null)

onMounted(async () => {
    const res = await axios.get('/me', {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    user.value = res.data
})
</script>
