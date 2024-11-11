<script setup>
import Form from './Form.vue';
const props =defineProps({
    usuarios:{type:Object}
});
</script>

<template>
    <Form :usuarios="usuarios" />
</template>