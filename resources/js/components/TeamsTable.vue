<script setup lang="ts">
import { ref, computed } from 'vue';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { showConfirm } from '@/lib/alerts';
import { router, Link } from '@inertiajs/vue3';

interface Team {
    id: number;
    name: string;
    projects: string[];
}

interface Props{
    teams: Team[];
    permissions: object;
}

const props = defineProps<Props>()
const search = ref('');

const filteredTeams = computed(() =>
  props.teams.filter(team =>
    team.name.toLowerCase().includes(search.value.toLowerCase())
  )
);
const handleDelete = async (id: number) => {
    if(await showConfirm('Deseja excluir essa equipe?', "Atenção!")) {
        router.delete(route('teams.delete', {id}));
    }
}
</script>

<template>
  <div class="space-y-4">
    <div class="flex justify-between items-center">
        <Input v-model="search" placeholder="Buscar por nome do grupo..." class="w-full sm:w-1/3" />
        <Link v-if="permissions.canCreate" :href="route('teams.register')"><Button>Criar equipe</Button></Link>
    </div>
    <div class="border rounded-lg overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-muted text-muted-foreground dark:bg-zinc-800">
          <tr>
            <th class="px-4 py-2">Cod.</th>
            <th class="px-4 py-2">Nome da equipe</th>
            <th class="px-4 py-2">Projetos</th>
            <th class="px-4 py-2 text-right">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="team in filteredTeams" :key="team.id" class="border-t hover:bg-muted/50">
            <td class="px-4 py-2">{{ team.id }}</td>
            <td class="px-4 py-2">{{ team.name }}</td>
            <td class="px-4 py-2 space-x-1">
              <Badge v-for="project in team.projects" :key="project" variant="secondary">
                {{ project }}
              </Badge>
            </td>
            <td v-if="permissions.canEdit" class="px-4 py-2 text-right">
                <Link :href="route('teams.edit', {id: team.id})">
                    <Button class="mr-1"> Editar </Button>
                </Link>
                <Button v-if="permissions.canDelete" @click="handleDelete(team.id)" variant="destructive">Excluir</Button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
