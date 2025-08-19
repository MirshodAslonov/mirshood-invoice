<template>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Clients</h2>
        <ul>
            <li v-for="c in clients" :key="c.id">{{ c.name }} - {{ c.email }}</li>
        </ul>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'

const clients = ref([])

onMounted(async () => {
    const res = await axios.get('/clients', {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    clients.value = res.data
})
</script>
