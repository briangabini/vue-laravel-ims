<script setup lang="ts">
import { SidebarInset } from '@/components/ui/sidebar';
import { toast } from 'vue-sonner';
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

interface Props {
    variant?: 'header' | 'sidebar';
    class?: string;
}

const props = defineProps<Props>();
const className = computed(() => props.class);

const page = usePage();

onMounted(() => {
    if (page.props.flash?.last_login_attempt) {
        const { successful, ip_address, logged_in_at } = page.props.flash.last_login_attempt;
        const title = successful ? 'Successful Login' : 'Failed Login Attempt';
        const description = successful
            ? `The last successful login was from IP address ${ip_address} on ${logged_in_at}.`
            : `The last failed login attempt was from IP address ${ip_address} on ${logged_in_at}.`;

        toast(title, {
            description: description,
        });
    }
});
</script>

<template>
    <SidebarInset v-if="props.variant === 'sidebar'" :class="className">
        <slot />
    </SidebarInset>
    <main v-else class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl" :class="className">
        <slot />
    </main>
</template>

