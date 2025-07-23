<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3'
import { type BreadcrumbItem } from '@/types';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

interface Users {
    id: number,
    name: string,
}

interface Projects {
    id: number,
    title: string,
}

interface Props{
    users: Users[];
    projects: Projects[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Nova equipe',
        href: '/teams/create',
    },
];

const props = defineProps<Props>()
const form = useForm({
  name: '',
  user_ids: [],
  project_ids: []
});

function submit() {
  form.post(route('teams.create'));
}
</script>

<template>
    <Head title="Equipe"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="submit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label>Nome do Time</Label>
                    <Input v-model="form.name" />
                </div>
                <div class="space-y-2">
                    <Label for="Usuarios">Usuários</Label>
                    <Select v-model="form.user_ids" multiple>
                        <SelectTrigger>
                        <SelectValue placeholder="Selecione a equipe..." />
                        </SelectTrigger>
                        <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="u in props.users" :key="u.id" :value="u.id">
                            {{ u.name }}
                            </SelectItem>
                        </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="space-y-2">
                    <Label for="Projetos">Projetos</Label>
                    <Select v-model="form.project_ids" multiple>
                        <SelectTrigger>
                        <SelectValue placeholder="Selecione os projetos..." />
                        </SelectTrigger>
                        <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="p in props.projects" :key="p.id" :value="p.id">
                            {{ p.title }}
                            </SelectItem>
                        </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <Button type="submit">Criar Time</Button>
            </form>
        </div>
    </AppLayout>
</template>