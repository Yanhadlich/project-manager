<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Link } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projetos',
        href: '/projects',
    },
];
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <Link :href="route('projects.create')"><Button>Novo projeto</Button></Link>
        </div>
    </AppLayout>
</template>
