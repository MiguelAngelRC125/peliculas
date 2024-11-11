<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const props = defineProps({
    estrenos:{type:Object},flash:{type:Object}
});
const form = useForm({id:'', title:''});
const showModalDel = ref(false);
const msj = ref( (props.flash.success != null) ? props.flash.success: '' );
const classMsj = ref( (props.flash.success != null) ? '' : 'hidden' );

const openModalDel = (b) =>{
    form.id = b.id;
    form.title = b.title;
    showModalDel.value = true;
}
const closeModalDel = () =>{
    showModalDel.value = false;
}
const deleteEstreno = () =>{
    form.delete(route('estrenos.destroy',form.id),{
        onSuccess: () => { ok('Estreno Eliminado')}
    });
}
const ok = (m) => {
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
}
</script>

<template>
    <Head title="Estrenos" />

    <AuthenticatedLayout>
		<template #header>
			Estrenos
		</template>
		<div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-green-500">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-green-600">Exito</span>
						<p class="text-sm text-gray-600">{{ msj }}</p>
					</div>
				</div>
			</div>
		<div class="w-full overflow-hidden rounded-lg border shadow-md">
			<div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                      <th class="px-4 py-3">#</th>
                      <th class="px-4 py-3">Nombre</th>
                      <th class="px-4 py-3">Apellidos</th>
                      <th class="px-4 py-3">Poster</th>
                      <th class="px-4 py-3">Detalle</th>
                      <th class="px-4 py-3">Editar</th>
                      <th class="px-4 py-3">Borrar</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="b,i in estrenos.data" :key="b.id" class="text-gray-700">
                            <td class="px-4 py-3 text-sm">
                                {{ (i+1) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ b.isbn }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ b.title }}
                            </td>
                            <td class="px-4 py-3 text-sm">

                                <img :src="'storage'+b.image" width="50">
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <NavLink :href="route('estrenos.show', b.id)">
                                <SecondaryButton >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>

                                </SecondaryButton>
                            </NavLink>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <NavLink :href="route('estrenos.edit',b.id)">
                                <WarningButton >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
</svg>
                                </WarningButton>
                            </NavLink>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <DangerButton @click="openModalDel(b)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                </DangerButton>
                            </td>
                        </tr>
                  </tbody>
                </table>
            </div>
            <div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="estrenos.links" />
				</div>
		</div>
        <Modal :show="showModalView" @close="closeModalView">
            <div class="p-6">
                <p>Usuario: <span class="text-lg font-medium text-gray-900">{{ v.name }}</span></p>
                Estrenos:
                <ol>
                    <li class="text-lg font-medium text-gray-900" v-for="b,i in v.estrenos">
                        {{ (i+1)+')'+b.title }}
                    </li>
                </ol>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalView">Cancelar</SecondaryButton>
            </div>
        </Modal>
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <div class="mt-6 mb-6 space-y-6 max-w-xl">
                    <InputGroup :text="'Name'" :required="'required'" v-model="form.name" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.name"></InputError>
                    <InputGroup :text="'Last Name'" :required="'required'" v-model="form.last_name" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
</svg>

                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.last_name"></InputError>
                    <PrimaryButton @click="save">Guardar</PrimaryButton>
                </div>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
            </div>
        </Modal>
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p class="text-2xl text-gray-500">
                    Estas seguro de borrar
                <span class="text-2xl font-medium text-gray-900">{{ form.title }}</span> ? </p>
                <PrimaryButton @click="deleteEstreno">Si, borrar</PrimaryButton>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
            </div>
        </Modal>
	</AuthenticatedLayout>
</template>