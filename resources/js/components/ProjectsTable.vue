<script setup lang="ts">
import { ref, computed } from 'vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { showConfirm } from '@/lib/alerts';
import { router, Link } from '@inertiajs/vue3';

interface Projects{
    id: number,
    title: string,
    client: string,
    status_id: number,
    is_active: number,
}

interface Props{
    projects: Projects[];
    permissions: object;
}

const props = defineProps<Props>()
const search = ref('');

const filteredProject = computed(() =>
  props.projects.filter(project =>
    project.title.toLowerCase().includes(search.value.toLowerCase())
  )
);
const handleDelete = async (id: number) => {
    if(await showConfirm('Deseja excluir esse projeto?', "Atenção!")) {
        router.delete(route('projects.delete', {id}));
    }
}
</script>

<template>
  <div class="space-y-4">
    <div class="flex justify-between items-center">
        <Input v-model="search" placeholder="Buscar por nome do projeto..." class="w-full sm:w-1/3" />
          <Link v-if="permissions.canCreate" :href="route('projects.register')"><Button>Novo projeto</Button></Link>
    </div>
    <div class="border rounded-lg overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-muted text-muted-foreground dark:bg-zinc-800">
          <tr>
            <th class="px-4 py-2">Cod.</th>
            <th class="px-4 py-2">Cliente</th>
            <th class="px-4 py-2">Projeto</th>
            <th class="px-4 py-2">Status</th>
            <th v-if="permissions.canEdit" class="px-4 py-2 text-right">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="project in filteredProject" :key="project.id" class="border-t hover:bg-muted/50">
            <td class="px-4 py-2">{{ project.id }}</td>
            <td class="px-4 py-2">{{ project.client }}</td>
            <td class="px-4 py-2">{{ project.title }}</td>
            <td class="px-4 py-2">{{ project.status_id }}</td>
            <td v-if="permissions.canEdit" class="px-4 py-2 text-right">
                <Link :href="route('projects.edit', {id: project.id})">
                    <Button class="mr-1"> Editar </Button>
                </Link>
                <Button v-if="permissions.canDelete" @click="handleDelete(project.id)" variant="destructive"> Excluir </Button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
