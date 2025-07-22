<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { showToast } from '@/lib/alerts';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { watch } from 'vue';

interface Projects{
    id: number,
    title: string,
    client: string,
    status_id: number,
    is_active: number,
}

interface Props{
    projects: Projects[];
}

const props = defineProps<Props>()
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
            <div>
                <Table>
                    <TableCaption>Todos os projetos</TableCaption>
                    <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                            Cod.
                        </TableHead>
                        <TableHead>Cliente</TableHead>
                        <TableHead>Projeto</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Ativo</TableHead>
                        <TableHead class="text-right">
                            Ações
                        </TableHead>
                    </TableRow>
                    </TableHeader>
                    <TableBody>
                    <TableRow v-for="project in props.projects" :key="project.id">
                        <TableCell class="font-medium">{{ project.id }}</TableCell>
                        <TableCell>{{ project.client }}</TableCell>
                        <TableCell>{{ project.title }}</TableCell>
                        <TableCell>{{ project.status_id }}</TableCell>
                        <TableCell>{{ project.is_active }}</TableCell>
                        <TableCell class="text-right">
                        </TableCell>
                    </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
