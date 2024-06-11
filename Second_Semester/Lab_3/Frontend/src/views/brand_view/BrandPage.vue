<script setup>
import {onMounted, ref} from 'vue';
import axios from "axios"
const brand_list = ref({}); 

onMounted(
    ()=>{
        get_brand_list();
    }

)

async function delete_brand(id){
    axios.post("http://localhost/delete-brand", {"brand_id": id})
    .then((response) => {
        brand_list.value = brand_list.value.filter(item => item.brand_id != id);
    })
    .catch(function (error) {
        console.log(error);
    });

}


async function get_brand_list(){
        const response = await fetch("http://localhost/brand-list.json");
        brand_list.value = (await response.json())["brands"];
}

</script>




<template class="container">

    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Название компании</th>
            <th>Изменить компанию</th>
            <th>Удалить компанию</th>
        </tr>
    </thead>

        <tbody>
            <tr v-for="brand in brand_list">
                <td>
                    <RouterLink :to="/products/ + brand.brand_id">{{brand.brand_name}}</RouterLink>
                </td>
                <td>
                    <RouterLink class="btn btn-success" :to="/brand_change_form/ + brand.brand_id">Изменить компанию</RouterLink>
                </td>
                <td>
                    <button class="btn btn-danger" @click="delete_brand(brand.brand_id)">Удалить компанию</button>
                </td>
            </tr>
        </tbody>
    </table>


    <RouterLink class="btn btn-success" to="/brand_create_form">Создать компанию</RouterLink>

</template>