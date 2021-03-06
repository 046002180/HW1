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

function isCharString(string) {
    const regex = /[0-9\.\*\\"!£$%&\/()=?^'§°#@{}\[\]]/g;
    return !(regex.test(string));
}
function isNumber(number) {
    const regex = /[a-zA-Z\.\*\\"!£$%&\/()=?^'§°#@{}\[\]]/g;
    return !regex.test(number);
}
function validateEmail(email) {
    const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g;
    return regex.test(email);
}
function containsNumbers(string) {
    const regex_n = /[0-9]/g;
    return regex_n.test(string);
}
function containsSpecialChars(string) {
    const regex_sp = /[@#§°ç{}\\\|!"£$%&/\(\)\=\?\^]/g;
    return regex_sp.test(string);
}
function removeBox(event) {
    const box = event.currentTarget.parentNode.parentNode;
    box.remove();
    document.body.classList.remove('no-scroll');
}
function formCheck(event) {
    const form = document.forms['user-data'];
    if (form.nome.value.length === 0 || form.cognome.value.length === 0 || form.stato.value.length === 0
        || form.citta.value.length === 0 || form.indirizzo.value.length === 0 || form.numero.value.length === 0
        || form.email.value.length === 0 || form.password.length === 0 || form.password2.value.length === 0) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Compila tutti i campi';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!isCharString(form.nome.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Nome non valido';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!isCharString(form.cognome.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Cognome non valido';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!isCharString(form.stato.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Stato non valido';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!isCharString(form.citta.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Città non valida';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!isNumber(form.numero.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Numero non valido';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!validateEmail(form.email.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Email non valida'
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (form.password.value !== form.password2.value) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Le password inserire non coincidono';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (form.password.value.length<8||form.password.value.lenght>16) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = 'Lunghezza password non ammessa';
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!containsNumbers(form.password.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = "La password inserita non contiene numeri";
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!containsSpecialChars(form.password.value)) {
        const main = document.querySelector('#general');
        const div = document.createElement('div');
        div.dataset.id = 'err_box';
        const div2 = document.createElement('div');
        div2.dataset.id = 'c_box';
        const img = document.createElement('img');
        img.classList.add('close_img');
        img.src = 'img/common/close.png';
        img.addEventListener('click', removeBox);
        const div3 = document.createElement('div');
        div3.dataset.id = 'err_m_box';
        div3.classList.add('err_message');
        div3.textContent = "La password inserita non contiene caratteri speciali";
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
}
const submit = document.querySelector("#submit-label input");
submit.addEventListener("click", formCheck);
