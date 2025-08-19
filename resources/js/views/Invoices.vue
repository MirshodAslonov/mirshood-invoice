<template>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Invoices</h2>
        <ul>
            <li v-for="inv in invoices" :key="inv.id">
                Invoice #{{ inv.id }} — {{ inv.status }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'

const invoices = ref([])

onMounted(async () => {
    const res = await axios.get('/invoices', {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    invoices.value = res.data
})
</script>
