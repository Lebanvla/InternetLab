<script setup>
import { onMounted, ref } from 'vue'
import axios from "axios"


function isEmpty(_str) {
    let str = _str.toString();
    return !str.trim().length;
}




const brand_list = ref({}); 
const group_list = ref({}); 

const image = ref(null);
const file = ref(null);
const name = ref('');
const price = ref('');
const description = ref('');
const brand_id = ref('');
const group_id = ref('');


const name_error=ref('')
const description_error=ref('')
const price_error=ref('')
const brand_error=ref('')
const group_error=ref('')
const file_error = ref('');
const have_file = ref(false);

onMounted(
    ()=>{
        get_brand_list();
        get_group_list();
    }

)

async function get_group_list(){
        const response = await fetch("http://localhost/group-list.json");
        group_list.value = (await response.json())["groups"];
}

async function get_brand_list(){
        const response = await fetch("http://localhost/brand-list.json");
        brand_list.value = (await response.json())["brands"];
    }


function create_product(){
    
    let error_count = 0;

    if(isEmpty(name.value)){
        name_error.value="Имя не должно быть пустым";
        error_count++;
    }
    else{
        name_error.value="";
    }


    if(!have_file.value){
        file_error.value="Вставьте картинку";
        error_count++;
    }
    else{
        file_error.value="";
    }



    if(isEmpty(description.value)){
        description_error.value="Описание не должно быть пустым";
        error_count++;

    }
    else{
        description_error.value="";
    }


    if(isEmpty(price.value)){
        price_error.value="Цена не должна быть пустой";
        error_count++;

    }
    else{
        price_error.value="";
    }

    if(isEmpty(brand_id.value)){
        brand_error.value="Выбор бренда не должно быть пустым";
        error_count++;

    }
    else{
        brand_error.value="";
    }

    if(isEmpty(group_id.value)){
        group_error.value="Выбор группы не должно быть пустым";
        error_count++;

    }
    else{
        group_error.value="";
    }

    
    

    let formData = new FormData();
    formData.append('file', file.value);
    formData.append('name', name.value)
    formData.append('price', price.value);
    formData.append('description', description.value);
    formData.append('brand_id', brand_id.value);
    formData.append('group_id', group_id.value)



        axios.post("http://localhost/create-product", 
        formData,{
            headers: {
                'Content-Type': 'multipart/form-data',
                'Authorization': 'Bearer ...', 
                }
            }
        );
    }



function AddFile(){
    file.value = image.value.files[0];
    if(file.value !== null){
        have_file.value = true;
    }
}
</script>

<template>
<div class="mb-3">
    <input v-model="name" class="form-control " placeholder="Введите название продукта">
    <br>
    <div style="background-color: red;">{{name_error}}</div>
    <br>
    <label for="file" >Вставьте картинку</label>
    <br>
    <div style="background-color: red;">{{file_error}}</div>
    <br>
    <input type="file" ref="image" @change="AddFile()"/>
    <br><br>
    <input v-model="price" class="form-control" type="number" placeholder="Введите цену продукта">
    <br>
    <div style="background-color: red;">{{price_error}}</div>
    <br>
    <input v-model="description" class="form-control " placeholder="Введите описание продукта">
    <br>
    <div style="background-color: red;">{{description_error}}</div>
    <br>
    <select v-model="brand_id">
        <option v-for="brand in brand_list" :value="brand.brand_id" > {{brand.brand_name}} </option>
    </select>
    <br>
    <div style="background-color: red;">{{brand_error}}</div>
    <br><br>
    <select v-model="group_id">
        <option v-for="group in group_list" :value="group.group_id" > {{group.group_name}} </option>
    </select>
    <br>
    <div style="background-color: red;">{{group_error}}</div>


    <br>
    <br><button type="button" @click="create_product" class="btn btn-success col-2">Создать продукт</button>
</div>
</template>