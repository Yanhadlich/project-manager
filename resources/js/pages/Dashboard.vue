<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { User } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { Laugh } from 'lucide-vue-next';
import { ref } from 'vue';

const expandedCard = ref(null)
const page = usePage();
const user = page.props.auth.user as User;

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="[{title: 'Dashboard', href: '/dashboard'}]">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class=" flex justify-center min-h-[100vh] rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <label class="text-2xl flex items-center"> <Laugh class="m-1"/> Bem vindo {{ user.name }}</label>
            </div>

                <div class="flex gap-4 transition-all duration-500 ease-in-out">
                    <div
                    @click="expandedCard = expandedCard === 'projects' ? null : 'projects'"
                    class="relative h-64 cursor-pointer overflow-hidden rounded-xl border border-sidebar-border/70 p-4 transition-all duration-500 ease-in-out dark:border-sidebar-border"
                    :class="[
                        expandedCard === 'projects'
                        ? 'flex-[5] shadow-lg bg-gray-100 dark:bg-gray-800 hover:scale-[1.02]'
                        : expandedCard === 'teams'
                        ? 'flex-[1]'
                        : 'flex-1'
                    ]"
                    >
                        <div class="flex h-full items-center justify-center text-lg font-bold">
                            PROJETOS
                        </div>
                    </div>

                    <div
                    @click="expandedCard = expandedCard === 'teams' ? null : 'teams'"
                    class="relative h-64 cursor-pointer overflow-hidden rounded-xl border border-sidebar-border/70 p-4 transition-all duration-500 ease-in-out dark:border-sidebar-border"
                    :class="[
                        expandedCard === 'teams'
                        ? 'flex-[5] shadow-lg bg-gray-100 dark:bg-gray-800 hover:scale-[1.02]'
                        : expandedCard === 'projects'
                        ? 'flex-[1]'
                        : 'flex-1'
                    ]"
                    >
                        <div class="flex h-full items-center justify-center text-lg font-bold">
                            TIMES
                        </div>
                    </div>
                </div>

        </div>
    </AppLayout>
</template>
