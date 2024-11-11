<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import select2 from 'select2';
select2();
import Select2 from 'vue3-select2-component';

const props =defineProps({
    usuarios:{type:Object},
    estreno:{type:Object},
    usuariosOfEstreno:{type:Object}
});
const form = useForm({
    id:'', isbn:'', description:'', title:'', publisher:'', release_date:'', image:'',usuarios:[]
});

const title_form = ref(
    (props.estreno == null) ? 'Agregar estreno' : 'Editar estreno'
);
const req = ref('required');
const srcImg = ref('../../storage/img/cintapelicula.png')
const msj = ref('');
const classMsj = ref('hidden');
const options = ref([]);
props.usuarios.map( (row) =>{
    options.value.push({'id':row.id, 'text':row.last_name+' '+row.name});
});

if(props.estreno != null){
    form.isbn = props.estreno.isbn;
    form.title = props.estreno.title;
    form.description = props.estreno.description;
    form.release_date = props.estreno.release_date;
    form.publisher = props.estreno.publisher;
    form.image = props.estreno.image;
    form.id = props.estreno.id;
    srcImg.value = '../../storage'+props.estreno.image;
    props.usuariosOfEstreno.map( (row) =>(
        form.usuarios.push(row.id)
    ))
}
const save = () =>{
    if(props.estreno == null){
        form.post(route('estrenos.store'),{
            onSuccess: () =>{ ok('Estreno creado')}
        });
    }
    else{
        form.post(route('updateestreno'))
    }
}
const ok = () =>{
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
}
const showImg = (e) =>{
    form.image = e.target.files[0];
    srcImg.value = URL.createObjectURL(e.target.files[0]);
}
</script>

<template>
    <Head title="Estreno" />

    <AuthenticatedLayout>
		<template #header>
			<div class="inline-flex overflow-hidden mb-4 w-full">
                {{ title_form }}
                <NavLink :href="route('estrenos.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>

                    </DarkButton>
                </NavLink>
            </div>
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
        <div class="grid grap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <form class="mt-6 mb-6 space-y-6 max-w-xl" @submit.prevent="save">
                    <InputGroup :text="'ISBN'" :required="'required'" v-model="form.isbn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>

                    </InputGroup>
                    <InputError :message="form.errors.isbn" />
                    <InputGroup :text="'Descripcion'" :required="'required'" v-model="form.description">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>

                    </InputGroup>
                    <InputError :message="form.errors.description" />
                    <InputGroup :text="'Titulo'" :required="'required'" v-model="form.title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
</svg>


                    </InputGroup>
                    <InputError :message="form.errors.title" />
                    <InputGroup :text="'Productora'" :required="'required'" v-model="form.publisher">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
</svg>

                    </InputGroup>
                    <InputError :message="form.errors.publisher" />
                    <InputGroup :text="'Calendario'" :required="'required'" v-model="form.release_date" :type="'date'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
</svg>
                    </InputGroup>
                    <InputError :message="form.errors.release_date" />
                    <InputGroup v-if="props.estreno == null" @change="showImg($event)" :text="'Poster'" :required="'required'" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
</svg>
                    </InputGroup>
                    <InputGroup v-else :text="'Poster'" @change="showImg($event)" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
</svg>
                    </InputGroup>
                    <InputError :message="form.errors.image" />
                    <span class="mt-2">Agregar Usuarios</span>
                    <Select2 v-model="form.usuarios" :options="options" :settings="{multiple:true, width:'100%'}" @change="form.usuarios = $event.target.value" />
                    <InputError :message="form.errors.usuarios" />
                    <PrimaryButton>Guardar</PrimaryButton>
                </form>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="srcImg" width="500">
            </div>
        </div>
    </AuthenticatedLayout>
</template>