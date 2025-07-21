<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { showToast } from '@/lib/alerts';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

const page = usePage();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projetos',
        href: '/projects',
    },
];

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

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <Link :href="route('projects.register')"><Button>Novo projeto</Button></Link>
        </div>
    </AppLayout>
</template>
