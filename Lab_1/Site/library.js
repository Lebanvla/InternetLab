function change_the_good(my_id){
    let element = document.getElementById(my_id), other_elem_1, other_elem_2;
    switch(my_id){
        case "23kg":
            other_elem_1 = document.getElementById("6kg");
            other_elem_2 = document.getElementById("1_litr");
            break;
        case "6kg":
            other_elem_1 = document.getElementById("23kg");
            other_elem_2 = document.getElementById("1_litr");
            break;
        case "1_litr":
            other_elem_1 = document.getElementById("6kg");
            other_elem_2 = document.getElementById("1_litr");
            break;
    }
    element.classList.remove("btn", "btn-outline-success");
    element.classList.add("btn", "btn-success");
    if(other_elem_1.classList.conteins("btn-success")){
        other_elem_1.classList.remove("btn", "btn-success");
        other_elem_1.classList.add("btn", "btn-outline-success");
    }
    else {
        other_elem_2.classList.remove("btn", "btn-success");
        other_elem_2.classList.add("btn", "btn-outline-success");
    }
}

function change_the_text(id){
    let element = document.getElementById(id);
    if(element.classList.contains("nonactive")){
        element.classList.remove("nonactive");
        element.classList.add("active");
        
        //Проверяем, какой элемент активен

        let old_elem; 
        switch(id){
            case "description_b":
                old_elem = document.getElementById("characteristic_b") ? 
                           document.getElementById("characteristic_b") : document.getElementById("sertuficate_b");
            case "characteristic_b":
                old_elem = document.getElementById("description_b") ? 
                           document.getElementById("description_b") : document.getElementById("sertuficate_b");
            case "sertuficate_b":
                old_elem = document.getElementById("description_b") ? 
                           document.getElementById("description_b") : document.getElementById("characteristic_b");
        }

        old_elem.classList.remove("active");
        old_elem.classList.add("nonactive");
    }
}
