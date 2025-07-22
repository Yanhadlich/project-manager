<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Check, ChevronsUpDown, Search } from 'lucide-vue-next';
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

const roles = [
    { id: 1, name: 'Administrador' },
    { id: 2, name: 'Gerente' },
    { id: 3, name: 'Desenvolvedor' },
    { id: 4, name: 'Cliente' },
];

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: null,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <div class="grid gap-2">
                    <Combobox v-model="form.role" by="id">
                        <ComboboxAnchor as-child>
                            <ComboboxTrigger as-child>
                                <Button variant="outline" class="w-full" tabindex="5">
                                    {{ form.role ? form.role.name : 'Selecione uma categoria' }}
                                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </ComboboxTrigger>
                        </ComboboxAnchor>
                        <ComboboxList class="w-full">
                        <div class="relative w-full max-w-sm items-center">
                            <ComboboxInput class="pl-9 focus-visible:ring-0 border-0 border-b rounded-none h-10" placeholder="Selecione uma categoria" />
                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                            <Search class="size-4 text-muted-foreground" />
                            </span>
                        </div>

                        <ComboboxEmpty>
                            Nenhuma categoria encontrada.
                        </ComboboxEmpty>

                        <ComboboxGroup>
                            <ComboboxItem
                            v-for="role in roles"
                            :key="role?.id"
                            :value="role"
                            >
                            {{ role?.name}}

                            </ComboboxItem>
                        </ComboboxGroup>
                        </ComboboxList>
                    </Combobox>
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="6" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>