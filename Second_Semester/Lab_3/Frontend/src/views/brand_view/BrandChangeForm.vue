<script setup>
    import {onMounted, ref} from 'vue';
    import axios from "axios"



    const brand_n = ref('')
    const brand_id = ref('')
    get_brand_item()

    
    function change_brand(){
        axios.post("http://localhost/update-brand", {
            "id": brand_id.value,
            "brand_name": brand_n.value
        })
        .then((response) => {
            alert("Запись успешно изменена, вернитесь на страницу с брендами");
        })
        .catch(function (error) {
            console.log(error);
        });

        

    }
    async function get_brand_item(){
        let my_url = "http://localhost/get-brand/" + window.location.href.split("/").at(-1) + ".json";
        console.log(my_url);
        const response = await fetch(my_url);
        if(response.ok){
            const json = (await response.json());
            brand_n.value = json["brand_name"];
            brand_id.value = json["brand_id"];
            console.log(brand_id.value);
            console.log(brand_n.value);
        }
        else{
            console.log(response.statusText)
        }
    }

</script>
{{brand_n}}
<template>

    <form name="brand_create_form">
        
        <div class="mb-3">
            <input v-model="brand_n" class="form-control " placeholder="Введите название компании">
            <br><button type="button" @click="change_brand" class="btn btn-success col-2">Изменить бренд</button>
        </div>
    </form>
</template>