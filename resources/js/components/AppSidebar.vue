<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import { HomeIcon, UserIcon } from '@heroicons/vue/24/outline';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const mainNavItems = computed(() => {
    let items = [];
    if (user.value && (user.value.role.name === 'admin' || user.value.role.name === 'manager')) {
        items = [
            {
                title: 'Dashboard',
                href: route('admin.dashboard'),
                icon: LayoutGrid,
            },
            {
                title: 'Products',
                href: route('admin.products.index'),
                icon: Folder,
            },
            {
                title: 'Categories',
                href: route('admin.categories.index'),
                icon: Folder,
            },
            {
                title: 'Orders',
                href: route('admin.orders.index'),
                icon: Folder,
            },
            
        ];
        if (user.value.role.name === 'admin') {
            items.push({
                title: 'Users',
                href: route('admin.users.index'),
                icon: UserIcon,
            });
            items.push({
                title: 'Logs',
                href: route('admin.logs'),
                icon: BookOpen,
            });
            items.push({
                title: 'Roles',
                href: route('admin.roles.index'),
                icon: UserIcon,
            });
        }
    } else if (user.value && user.value.role.name === 'customer') {
        items = [
            {
                title: 'Home',
                href: route('home'),
                icon: HomeIcon,
            },
            {
                title: 'My Orders',
                href: route('my-orders.index'),
                icon: Folder,
            },
            
        ];
    }
    return items;
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('home')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
<!--            <NavFooter :items="footerNavItems" />-->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
