<script setup>
import {onMounted, ref} from 'vue';
const brand_list = ref({}); 


onMounted(
    ()=>{
        get_brand_list();
    }

)

async function delete_brand(id){
    const response = await fetch(
        "http://localhost/delete-brand/",
        {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body:{
                "id": id
            }
        }
    );
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
                    {{ brand.name }}
                </td>
                <td>
                    <RouterLink class="btn btn-secondary" to="/brand_change_form">Изменить компанию</RouterLink>
                </td>
                <td>
                    <button class="btn btn-secondary" @click="delete_brand(brand.id)">Удалить компанию</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>