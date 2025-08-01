<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Button } from '@/components/ui/button';

interface Order {
    id: number;
    order_number: string;
    total_amount: number;
    status: string;
    created_at: string;
    user: { name: string };
}

const props = defineProps<{ order: Order }>();

const form = useForm({
    status: props.order.status,
});

const submit = () => {
    form.put(route('admin.orders.update', props.order.order_number));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: route('admin.orders.index'),
    },
    {
        title: `Order #${props.order.order_number}`,
        href: route('admin.orders.show', props.order.order_number),
    },
    {
        title: 'Edit Status',
        href: '#',
    },
];
</script>

<template>
    <Head :title="`Edit Order Status: #${order.order_number}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Edit Order Status: #{{ order.order_number }}</h1>
                    <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <Label for="status">Order Status</Label>
                            <Select v-model="form.status">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="pending">Pending</SelectItem>
                                    <SelectItem value="processing">Processing</SelectItem>
                                    <SelectItem value="shipped">Shipped</SelectItem>
                                    <SelectItem value="delivered">Delivered</SelectItem>
                                    <SelectItem value="cancelled">Cancelled</SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">{{ form.errors.status }}</div>
                        </div>

                        <Button type="submit" :disabled="form.processing">
                            Update Status
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
