<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

interface LogEntry {
    timestamp: string;
    level: string;
    message: string;
}

interface LogPaginationData {
    data: LogEntry[];
    links: { url: string | null; label: string; active: boolean }[];
    current_page: number;
    last_page: number;
    from: number;
    to: number;
    total: number;
}

defineProps<{ logs: LogPaginationData }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Logs',
        href: '#',
    },
];

const selectedLog = ref<LogEntry | null>(null);
const isModalOpen = ref(false);

const openLogModal = (log: LogEntry) => {
    selectedLog.value = log;
    isModalOpen.value = true;
};
</script>

<template>
    <Head title="System Logs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">System Logs</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Timestamp</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Level</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(log, index) in logs.data" :key="index" @click="openLogModal(log)" class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ log.timestamp }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ log.level }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100 truncate max-w-xs">{{ log.message }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Showing {{ logs.from }} to {{ logs.to }} of {{ logs.total }} results
                        </div>
                        <div class="flex space-x-1">
                            <!-- eslint-disable vue/no-v-text-v-html-on-component -->
                            <Link
                                v-for="link in logs.links"
                                :key="link.label"
                                :href="link.url || '#'"
                                class="px-3 py-1 text-sm rounded-md"
                                :class="{
                                    'bg-indigo-500 text-white': link.active,
                                    'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600': !link.active,
                                    'pointer-events-none opacity-50': !link.url,
                                }"
                                v-html="link.label"
                            />
                            <!-- eslint-enable vue/no-v-text-v-html-on-component -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Dialog v-model:open="isModalOpen">
            <DialogContent class="sm:max-w-[800px]">
                <DialogHeader>
                    <DialogTitle>Log Entry Details</DialogTitle>
                    <DialogDescription>
                        Full details of the selected log entry.
                    </DialogDescription>
                </DialogHeader>
                <div v-if="selectedLog" class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <span class="text-sm font-medium">Timestamp:</span>
                        <span class="col-span-3 text-sm">{{ selectedLog.timestamp }}</span>
                    </div>
                    <div class="grid grid-cols-4 items-center gap-4">
                        <span class="text-sm font-medium">Level:</span>
                        <span class="col-span-3 text-sm">{{ selectedLog.level }}</span>
                    </div>
                    <div class="grid grid-cols-4 items-start gap-4">
                        <span class="text-sm font-medium">Message:</span>
                        <span class="col-span-3 text-sm whitespace-pre-wrap">{{ selectedLog.message }}</span>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>