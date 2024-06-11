<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Grass_header from './components/grass_header.vue';
import Grass_footer from './components/grass_footer.vue';

</script>

<template>
  <body class="container">
  <Grass_header/>
  <RouterView />
  <Grass_footer/>
</body>

</template>
