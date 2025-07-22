<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    Combobox, 
    ComboboxAnchor, 
    ComboboxEmpty, 
    ComboboxGroup, 
    ComboboxInput, 
    ComboboxItem, 
    ComboboxItemIndicator, 
    ComboboxList, 
    ComboboxTrigger 
} from '@/components/ui/combobox';
import { ChevronsUpDown } from 'lucide-vue-next';

interface Project{
    id: number,
    title: string,
    client: string,
    status_id: number,
    is_active: number,
}

interface Props{
    project: Project;
    projectStatus: {id: number, name: string}[];
}

const props = defineProps<Props>();

const form = useForm({
    client:props.project.client,
    title:props.project.title,
    status: props.projectStatus.find(status => status.id === props.project.status_id) || null,
})

const handleSubmit = () => {
    form.put(route('projects.update', {project: props.project}))
}
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="[{title: 'Editar projeto', href: `projects/${props.project.id}/edit`}]">
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
                <div class="space-y-2">
                    <Combobox required v-model="form.status" by="id">
                        <ComboboxAnchor as-child>
                            <ComboboxTrigger as-child>
                                <Button variant="outline" class="w-full" tabindex="5">
                                    {{ form.status?.name }}
                                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </ComboboxTrigger>
                        </ComboboxAnchor>
                        <ComboboxList class="w-full">
                        <div class="relative w-full max-w-sm items-center">
                            <ComboboxInput class="pl-9 focus-visible:ring-0 border-0 border-b rounded-none h-10" placeholder="Selecione um status" />
                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                            <Search class="size-4 text-muted-foreground" />
                            </span>
                        </div>

                        <ComboboxEmpty>
                            Nenhum status encontrado.
                        </ComboboxEmpty>

                        <ComboboxGroup>
                            <ComboboxItem
                            v-for="status in projectStatus"
                            :key="status?.id"
                            :value="status"
                            >
                            {{ status?.name}}

                            </ComboboxItem>
                        </ComboboxGroup>
                        </ComboboxList>
                    </Combobox>
                </div>

                <Button type="submit">Salvar</Button>
            </form>
        </div>
    </AppLayout>
</template>
