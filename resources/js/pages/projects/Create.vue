<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Novo projeto',
        href: '/projects/register',
    },
];

const form = useForm({
    'client':'',
    'title':'',
});

const handleSubmit = () => {
    form.post(route('projects.create'))
}
</script>

<template>
    <Head title="">Projetos</Head>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="Nome do cliente">Nome do cliente: </Label>
                    <Input v-model="form.client" type="text" placeholder="Nome do cliente"/>
                    <InputError :message="form.errors.client" />
                </div>
                <div class="space-y-2">
                    <Label for="Projeto">Nome do projeto</Label>
                    <Input v-model="form.title" type="text" placeholder="Nome do projeto"/>
                    <InputError :message="form.errors.title" />
                </div>
                <Button type="submit">Criar projeto</Button>
            </form>
        </div>
    </AppLayout>
</template>