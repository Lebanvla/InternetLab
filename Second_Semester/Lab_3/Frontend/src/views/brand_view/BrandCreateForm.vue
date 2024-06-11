<script setup>
    import { ref } from 'vue'
    import axios from "axios"


    const brand_n = ref('')
    async function create_brand(){
        axios.post("http://localhost/create-brand", 
        {
            "brand_name":  brand_n.value
        })
        .then((response) => {
            alert("Запись успешно создана, вернитесь на страницу с брендами");
        })
        .catch(function (error) {
            console.log(error);
        });
    }
</script>

<template>
    <form name="brand_create_form">
        <div class="mb-3">
            <input v-model="brand_n" class="form-control " placeholder="Введите название компании">
            <br><button type="button" @click="create_brand" class="btn btn-success col-2">Создать бренд</button>
        </div>
    </form>
</template>