<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Grass_header from './components/grass_header.vue';
</script>

<template>
  <body class="container">
  <Grass_header/>
  <RouterView />
</body>

</template>
