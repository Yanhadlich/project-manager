<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { showToast } from '@/lib/alerts';
import { Head, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import Label from '@/components/ui/label/Label.vue';
import ProjectsTable from '@/components/ProjectsTable.vue';

interface Projects{
    id: number,
    title: string,
    client: string,
    status_name: number,
    is_active: number,
}

interface Props{
    projects: Projects[];
    permissions: object;
}

const props = defineProps<Props>()
const page = usePage();

watch (
    () => page.props.flash?.message,
    (message) => {
        if (!message) return;
        showToast(message, 'success');
    },{ immediate: true }
)
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="[{title: 'Projetos', href: `/projects`}]">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-4">
                <h1 class="text-2xl font-bold mb-4">Lista de Projetos</h1>
                <ProjectsTable :projects="props.projects" :permissions="props.permissions" />
            </div>
        </div>
    </AppLayout>
</template>

