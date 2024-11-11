<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    estreno:{type:Object},
    usuarios: {type:Object}
});

</script>
<template>
    <Head title="Estreno" />

    <AuthenticatedLayout>
		<template #header>
			<div class="inline-flex overflow-hidden mb-4 w-full">
                {{ estreno.title }}
                <NavLink :href="route('estrenos.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>

                    </DarkButton>
                </NavLink>
            </div>
		</template>
        <div class="grid grap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Descripcion: <span class="text-gray-900 font-semibold">{{ estreno.description }}</span></p>
                <p>ISBN: <span class="text-gray-900 font-semibold">{{ estreno.isbn }}</span></p>
                <p>Usuarios: <span v-for="a,i in usuarios" class="text-gray-900 font-semibold">
                   <a v-if="i == (usuarios.length-1)">{{ a.last_name+' '+a.name }}</a>
                   <a v-else>{{ a.last_name+' '+a.name+', ' }}</a>
                </span></p>
                <p>Productora: <span class="text-gray-900 font-semibold">{{ estreno.publisher }}</span></p>
                <p>Fecha de lanzamiento: <span class="text-gray-900 font-semibold">{{ estreno.release_date }}</span></p>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="'../storage'+estreno.image" :alt="estreno.title" width="500">
            </div>
        </div>
    </AuthenticatedLayout>
</template>