<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { showToast } from '@/lib/alerts';
import { Head, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import TeamsTable from '@/components/TeamsTable.vue';

interface Teams{
    id: number,
    name: string,
    projects: string[],
}

interface Props{
    teams: Teams[];
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
    <Head title="Equipes" />
    <AppLayout :breadcrumbs="[{title: 'Equipes', href: `/teams`}]">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-4">
                <h1 class="text-2xl font-bold mb-4">Lista de Equipes</h1>
                <TeamsTable :teams="props.teams" :permissions="permissions" />
            </div>
        </div>
    </AppLayout>
</template>
