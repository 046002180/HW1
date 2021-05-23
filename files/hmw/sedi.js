function show_menu() {
       let long_menu = document.querySelector("#long-menu");
       long_menu.style.display = "flex";
}

const small_menu = document.querySelector("#small-menu");
small_menu.addEventListener("click", show_menu);

function hide_menu() {
       let long_menu = document.querySelector("#long-menu");
       long_menu.style.display = "none";
}

const lm_button = document.querySelector("#lm-button");
lm_button.addEventListener("click", hide_menu);



//VARIABILE GLOBALE CHE PERMETTE DI GESTIRE IL CAMBIO DELLE IMMAGINI
let city_index = 0;

function change_view(index) {
       const map = document.querySelector("#map-img");
       const images = document.querySelectorAll(".external-img");
       const city_name = document.querySelector("#city-name");
       const description = document.querySelector("#description");
       city_name.innerHtml = '';
       description.innerHtml = '';
       switch (index % 4) {
              case 0:
                     //CAMBIA L'IMMAGINE DELLA MAPPA
                     map.src = "img/sedi/map-rome.jpg";
                     for (img of images) {
                            //CAMBIA L'IMMAGINE DELLA CITTÀ E DELLA SEDE
                            if (img.dataset.id === 'city-img')
                                   img.src = links.rome;
                            if (img.dataset.id === 'building-img')
                                   img.src = links.rome_hq;
                     }
                     city_name.textContent = 'Roma';
                     description.textContent = headquarters_description.rome;
                     break;
              case 1:
                     map.src = "img/sedi/map-houston.jpg";
                     for (img of images) {
                            if (img.dataset.id === 'city-img')
                                   img.src = links.houston;
                            if (img.dataset.id === 'building-img')
                                   img.src = links.houston_hq;
                     }
                     city_name.textContent = 'Houston';
                     description.textContent = headquarters_description.houston;
                     break;
              case 2:
                     map.src = "img/sedi/map-moscow.jpg";
                     for (img of images) {
                            if (img.dataset.id === 'city-img')
                                   img.src = links.moscow;
                            if (img.dataset.id === 'building-img')
                                   img.src = links.moscow_hq;
                     }
                     city_name.textContent = 'Mosca';
                     description.textContent = headquarters_description.moscow;
                     break;
              case 3:
                     map.src = "img/sedi/map-prague.jpg";
                     for (img of images) {
                            if (img.dataset.id === 'city-img')
                                   img.src = links.prague;
                            if (img.dataset.id === 'building-img')
                                   img.src = links.prague_hq;
                     }
                     city_name.textContent = 'Praga';
                     description.textContent = headquarters_description.prague;
                     break;
       }



}

function next_view() {
       city_index++;
       change_view(city_index);
}
const right_arrow = document.querySelector("#right-arrow");
right_arrow.addEventListener("click", next_view);

function previous_view() {
       city_index--;
       if (city_index < 0)
              city_index = 3;
       change_view(city_index);
}
const left_arrow = document.querySelector("#left-arrow");
left_arrow.addEventListener("click", previous_view);


const links = [];



function onResponse(response) {
       
       return response.json();
}
function onError(error) {
       console.log("Errore" + error);
}
function onJson(json){
       const images = json;
       const keys=Object.keys(images);
       for (key of keys){
              //PER OGNI CHIAVE NEL JSON VENGONO CARICATE,IN LINKS I PATH
              const nk=key.toLowerCase();
              links[nk] = images[key].City;
              links[nk+'_hq'] = images[key].HQ;
       }
       const img_container = document.querySelector('#city-image-box');
       //VISUALIZZA LA PRIMA COPPIA DI IMMAGINI
       let new_img = document.createElement('img');
       new_img.dataset.id = "city-img";
       new_img.classList.add("external-img");
       new_img.src = links['rome'];
       img_container.appendChild(new_img);
       const bottom_box = document.querySelector('#bottom-box');
       new_img = document.createElement('img');
       new_img.dataset.id = "building-img";
       new_img.classList.add("external-img");
       new_img.src = links['rome_hq'];
       bottom_box.appendChild(new_img);
}
fetch("http://localhost/prog/fetch_headquartersImages.php").then(onResponse,onError).then(onJson);