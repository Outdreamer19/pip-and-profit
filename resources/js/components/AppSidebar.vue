<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Users, ShoppingCart, Settings, DollarSign, MessageCircle, Home } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();
const user = page.props.auth.user;

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Courses',
        href: '/courses',
        icon: BookOpen,
    },
    {
        title: 'Pricing',
        href: '/pricing',
        icon: DollarSign,
    },
];

// Admin navigation items
const adminNavItems: NavItem[] = [
    {
        title: 'Admin Dashboard',
        href: '/admin',
        icon: LayoutGrid,
    },
    {
        title: 'Manage Courses',
        href: '/admin/courses',
        icon: BookOpen,
    },
    {
        title: 'User Management',
        href: '/admin/users',
        icon: Users,
    },
    {
        title: 'Orders & Payments',
        href: '/admin/orders',
        icon: ShoppingCart,
    },
];

// Public navigation items
const publicNavItems: NavItem[] = [
    {
        title: 'Home',
        href: '/',
        icon: Home,
    },
    {
        title: 'Courses',
        href: '/courses',
        icon: BookOpen,
    },
    {
        title: 'Pricing',
        href: '/pricing',
        icon: DollarSign,
    },
    {
        title: 'Contact',
        href: '/contact',
        icon: MessageCircle,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Settings',
        href: '/settings/profile',
        icon: Settings,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: Folder,
    },
];

// Determine which navigation items to show based on user role
const getNavItems = () => {
    if (user?.role === 'admin') {
        return [...mainNavItems, ...adminNavItems];
    } else if (user) {
        return mainNavItems;
    } else {
        return publicNavItems;
    }
};
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="user ? route('dashboard') : route('home')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="getNavItems()" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
