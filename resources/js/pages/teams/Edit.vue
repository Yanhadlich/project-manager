<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3'
import MultiSelectSearch from '@/components/ui/multiselect/MultiSelectSearch.vue';

interface Users {
    id: number,
    name: string,
}

interface Projects {
    id: number,
    title: string,
}

interface Team {
  id: number;
  name: string;
  user_ids: number[];
  project_ids: number[];
}

interface Props{
    users: Users[];
    projects: Projects[];
    team: Team;
}

const props = defineProps<Props>()
const form = useForm({
  name: props.team?.name || '',
  user_ids: props.team?.user_ids || [],
  project_ids: props.team?.project_ids || [],
});

function submit() {
  form.put(route('teams.update', { id: props.team.id }));
}
</script>

<template>
    <Head title="Equipe" />

    <AppLayout :breadcrumbs="[{ title: 'Editar equipe', href: `teams/${props.team.id}/edit` }]">
        <div class="p-4">
            <form @submit.prevent="submit" class="w-8/12 space-y-4">
                
                <div class="space-y-2">
                    <Label>Nome do Time</Label>
                    <Input v-model="form.name" />
                </div>

                <div class="space-y-2">
                    <Label>Usuários</Label>
                    <MultiSelectSearch
                    :options="props.users.map(u => ({ label: u.name, value: u.id }))"
                    v-model="form.user_ids"
                    placeholder="Selecione os usuários..."
                    />
                </div>

                <div class="space-y-2">
                    <Label>Projetos</Label>
                    <MultiSelectSearch
                    :options="props.projects.map(p => ({ label: p.title, value: p.id }))"
                    v-model="form.project_ids"
                    placeholder="Selecione os projetos..."
                    />
                </div>

                <Button type="submit">Salvar Time</Button>
            </form>
        </div>
    </AppLayout>
</template>