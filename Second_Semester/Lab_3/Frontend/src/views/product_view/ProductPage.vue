<script setup>
import {onMounted, ref} from 'vue';
import axios from 'axios';
const product_list = ref({}); 


onMounted(
    ()=>{
        get_product_list();
    }

)

async function delete_product(id){
    axios.delete("http://localhost/delete-product", {"id": id})
}


async function get_product_list(){
        const product_response = await fetch("http://localhost/product-list.json");
        product_list.value = (await product_response.json())["products"];

    }

</script>




<template class="container">

    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Картинка</th>
            <th>Имя продукта</th>
            <th>Цена продукта</th>
            <th>Компания</th>
            <th>Вид продукта</th>
            <th>Описание продукта</th>
            <th>Удалить продукт</th>
            <th>Изменить продукт</th>
        </tr>
    </thead>

        <tbody>
            <tr v-for="product in product_list">
                
                <td>
                    {{ product.image }}
                </td>
                <td>
                    {{ product.name }}
                </td>
                <td>
                    {{ product.price }}
                </td>
                <td>
                    {{ product.brand_name }}
                </td>
                <td>
                    {{ product.group_name }}
                </td>
                <td>
                    {{ product.description }}
                </td>
                <td>
                    <RouterLink class="btn btn-success" :to="/product_change_form/ + product.id">Изменить продукт</RouterLink>
                </td>
                <td>
                    <button class="btn btn-danger" @click="delete_product(product.id)">Удалить продукт</button>
                </td>
            </tr>
        </tbody>
    </table>

    <RouterLink class="btn btn-success" to="/product_create_form/">Создать продукт</RouterLink>


</template>