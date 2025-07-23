<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Building2, Folder, UsersRound } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

interface Props{
    permissions: object;
}

const props = defineProps<Props>()
const page = usePage();
const permissions = page.props.permissions?.canDelete || {};
const mainNavItems: NavItem[] = [
    {
        title: 'Projetos',
        href: '/projects',
        icon: Building2,
    },
    ...(permissions
    ? [{
        title: 'Times',
        href: '/teams',
        icon: UsersRound,
      }]
    : []),
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/Yanhadlich/project-manager',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://github.com/Yanhadlich/project-manager/README.md',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('projects.index')">
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
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
