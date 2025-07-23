<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { showConfirm, showToast } from '@/lib/alerts';
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
import Badge from '@/components/ui/badge/Badge.vue';

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

const handleDelete = async (id: number) => {
    if(await showConfirm('Deseja excluir essa equipe??', "Atenção!")) {
        router.delete(route('teams.delete', {id}));
    }
}

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
        <div class="p-4">
            <Link v-if="permissions.canCreate" :href="route('teams.register')"><Button>Criar equipe</Button></Link>
            <div>
                <Table>
                    <TableCaption>Equipes</TableCaption>
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
                        <TableRow v-for="team in props.teams" :key="team.id" class="">
                            <TableCell class="font-medium">{{ team.id }}</TableCell>
                            <TableCell>{{ team.name }}</TableCell>
                            <TableCell class="grid grid-flow-col gap-2 p-1 justify-start">
                                <div v-for="project in team.projects" class="flex items-center">
                                    <Badge> {{ project }} </Badge>
                                </div>
                            </TableCell>
                            <TableCell v-if="permissions.canEdit" class="text-right">
                                <Link :href="route('teams.edit', {id: team.id})">
                                    <Button class="mr-1"> Editar </Button>
                                </Link>
                                <Button v-if="permissions.canDelete" @click="handleDelete(team.id)" variant="destructive">Excluir</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
