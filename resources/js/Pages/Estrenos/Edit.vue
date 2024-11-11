<script setup>
import Form from './Form.vue';
const props =defineProps({
    usuarios:{type:Object},
    estreno:{type:Object},
    usuariosOfEstreno:{type:Object}
});
</script>

<template>
    <Form :usuarios="usuarios" :estreno="estreno" :usuariosOfEstreno="usuariosOfEstreno" />
</template>