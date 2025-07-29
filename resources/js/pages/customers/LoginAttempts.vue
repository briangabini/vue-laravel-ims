<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import SettingsLayout from '@/layouts/customers/SettingsLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { AlertCircle, Rocket } from 'lucide-vue-next';

interface LoginAttempt {
    successful: boolean;
    ip_address: string;
    logged_in_at: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedLoginAttempts {
    data: LoginAttempt[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
}

interface Props {
    loginAttempts: PaginatedLoginAttempts;
}

defineProps<Props>();

const formatTimestamp = (timestamp: string) => {
    return new Date(timestamp).toLocaleString();
};
</script>

<template>
    <AppLayout>
        <Head title="Login Attempts" />

        <SettingsLayout>
            <div class="space-y-6">
                <h2 class="text-2xl font-bold">Login Attempts</h2>
                <p class="text-muted-foreground">Review your recent login activity.</p>

                <div v-if="loginAttempts.data.length > 0" class="space-y-4">
                    <Alert v-for="attempt in loginAttempts.data" :key="attempt.logged_in_at" :variant="attempt.successful ? 'default' : 'destructive'">
                        <Rocket v-if="attempt.successful" class="h-4 w-4" />
                        <AlertCircle v-else class="h-4 w-4" />
                        <AlertTitle>{{ attempt.successful ? 'Successful Login' : 'Failed Login' }}</AlertTitle>
                        <AlertDescription>
                            Attempt from {{ attempt.ip_address }} on {{ formatTimestamp(attempt.logged_in_at) }}.
                        </AlertDescription>
                    </Alert>
                </div>
                <div v-else class="text-center text-muted-foreground">
                    No login attempts recorded.
                </div>

                <!-- Pagination Links -->
                <div v-if="loginAttempts.links.length > 3" class="flex justify-center mt-4">
                    <template v-for="link in loginAttempts.links" :key="link.label">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="px-3 py-2 mx-1 rounded-md"
                            :class="{ 'bg-primary text-primary-foreground': link.active, 'bg-muted': !link.active }"
                            v-html="link.label"
                        />
                        <span v-else class="px-3 py-2 mx-1 rounded-md bg-muted text-muted-foreground" v-html="link.label"></span>
                    </template>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>