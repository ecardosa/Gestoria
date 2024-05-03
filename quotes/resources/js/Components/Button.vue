<script setup>
import { defineProps, ref } from 'vue';

const { text } = defineProps({
  text: {
    type: String,
    required: true
  }
});

const buttonText = ref(text);
</script>

<template>
  <button class="btn btn-outline" type="button">{{ buttonText }}</button>
</template>

<style scoped>

</style>
