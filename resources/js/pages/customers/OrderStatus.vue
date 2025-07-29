<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

const orderId = ref('');

const checkStatus = () => {
    // Handle order status check
}
</script>

<template>
    <AppLayout>
        <div class="container mx-auto py-8">
            <div class="max-w-md mx-auto">
                <h1 class="text-2xl font-bold mb-4">Check Order Status</h1>
                <div class="flex space-x-2">
                    <Input v-model="orderId" placeholder="Enter your order ID" />
                    <Button @click="checkStatus">Check Status</Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>