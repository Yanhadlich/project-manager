<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { showConfirm, showToast } from '@/lib/alerts';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
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

interface Teams{
    id: number,
    name: string,
}

interface Props{
    teams: Teams[];
    permissions: object;
}

const props = defineProps<Props>()
const page = usePage();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Equipes',
        href: '/teams',
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
    <Head title="Equipes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <Link v-if="permissions.canCreate" :href="route('teams.register')"><Button>Novo projeto</Button></Link>
            <div>
                <Table>
                    <TableCaption>Todos os projetos</TableCaption>
                    <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                            Cod.
                        </TableHead>
                        <TableHead>Equipes</TableHead>
                        <TableHead>Projeto</TableHead>
                        <TableHead v-if="permissions.canEdit" class="text-right">
                            Ações
                        </TableHead>
                    </TableRow>
                    </TableHeader>
                    <TableBody>
                    <TableRow v-for="team in props.teams" :key="team.id">
                        <TableCell class="font-medium">{{ team.id }}</TableCell>
                        <TableCell>{{ team.name }}</TableCell>
                        <TableCell>{{ team.projects }}</TableCell>
                        <TableCell v-if="permissions.canEdit" class="text-right">
                            <Link :href="route('teams.edit', {id: team.id})"><Button class="mr-1"> Editar </Button></Link>
                            <Button v-if="permissions.canDelete" @click="handleDelete(team.id)" variant="destructive"> Excluir </Button>
                        </TableCell>
                    </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
