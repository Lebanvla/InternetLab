<script setup>
import { ref, onMounted, reactive } from 'vue'
import main_page_content from './assets/components/main_page_content.vue'

const content = reactive({ template: "<main_page_content />" })
function main_page() {
  alert("hello");
}
</script>

<template>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <div class="container-fluid">
        <button class="navbar-brand link-button" @click="main_page">
          Grass
        </button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">


            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="http://localhost/InternetLab/Second_Semester/Lab_1/">
                Домашняя страница(сброс)
              </a>
            </li>


            <li class="nav-item">
              <a class="nav-link"
                href="http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=read_all">Продукты</a>
            </li>


            <li class="nav-item">
              <a class="nav-link"
                href="http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all">Бренды</a>
            </li>


          </ul>
        </div>
      </div>
    </nav>
  </header>




  <main class="container">

    {{ content.template }}
  </main>



  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <h3>
        Пример подвала
      </h3>
    </ul>
    <p class="text-center text-muted">&copy; 2024, Lebanvla</p>
  </footer>
</template>
