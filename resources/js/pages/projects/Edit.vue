<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

interface Project{
    id: number,
    title: string,
    client: string,
    status_id: number,
    is_active: number,
}

const props = defineProps<{project: Project}>();

const form = useForm({
    client:props.project.client,
    title:props.project.title,
})

const handleSubmit = () => {
    form.put(route('projects.update', {project: props.project}))
}
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="[{title: 'Editar projeto',href: `projects/${props.project.id}/edit`}]">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="Nome do cliente"> Nome do cliente: </Label>
                    <Input v-model="form.client" type="text" placeholder="Nome do cliente"/>
                </div>
                <div class="space-y-2">
                    <Label for="Nome do projeto"> Nome do projeto: </Label>
                    <Input v-model="form.title" type="text" placeholder="Nome do projeto"/>
                </div>
                <Button type="submit">Salvar</Button>
            </form>
        </div>
    </AppLayout>
</template>
