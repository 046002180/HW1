function checkPasswordSp(password) {
    //controlla che la password contenga caratteri speciali
    const regex_sp = /[@#§°ç{}\\\|!"£$%&/\(\)\=\?\^]/g;
    return regex_sp.test(password);
}
function checkPasswordNum(password) {
    //controlla che la password contenga numeri
    const regex_num = /[0-9]/g;
    return regex_num.test(password);
}
function removeBox2(event) {
    const box = event.currentTarget.parentNode.parentNode;
    box.remove();
    document.body.classList.remove("no-scroll");
}

function formCheck(event) {
    const form = document.querySelector("#right-side-box form");
    if (form.current_password.value.length === 0 || form.new_password.value.length === 0 || form.new_password2.value.length === 0) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Compila tutti i campi del form";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.new_password.value.length !== form.new_password2.value.length ||
        form.new_password.value !== form.new_password2.value) {
        //Le password non coincidono
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Le password inserite non coincidono";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;

    }
    if (form.current_password.value.length < 8 || form.current_password.value.length > 16
        || !checkPasswordSp(form.current_password.value) || !checkPasswordSp(form.current_password.value)) {
        //La password corrente è errata ha già passato i controlli nella fase di signup 
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Password errata";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.new_password.value.length < 8) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Password inserita troppo corta";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.new_password.value.length > 16) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Password inserita troppo lunga";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (!checkPasswordNum(form.new_password.value)) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "La password non contiene numeri";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (!checkPasswordSp(form.new_password.value)) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "La password non contiene caratteri speciali";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
}



function showChangePasswordView() {
    const box = document.querySelector("#right-side-box");
    box.innerHTML = "";
    const form = document.createElement("form");
    form.dataset.id = "cp-form";
    form.setAttribute("name", "cp-form");
    form.setAttribute("method", "post");
    for (let i = 0; i < 3; i++) {
        const p = document.createElement("p");
        const label = document.createElement("label");
        const input = document.createElement("input");
        input.type = "password";
        input.classList.add("cp-input");
        label.classList.add("cp-label");
        if (i === 0) {
            label.textContent = "Password attuale";
            input.setAttribute("name", "current_password");
        }
        if (i === 1) {
            const div = document.createElement("div");
            div.dataset.id = "cp-message";
            div.textContent = "La password deve contenere almeno 8 (max 16) caratteri di cui almeno un numero e un carattere speciale (es. @,#,!).";
            form.appendChild(div);
            label.textContent = "Nuova password";
            input.setAttribute("name", "new_password");
        }
        if (i === 2) {
            label.textContent = "Conferma nuova password";
            input.setAttribute("name", "new_password2");
        }
        label.appendChild(input);
        p.appendChild(label);
        form.appendChild(p);
    }
    const submit = document.createElement("input");
    submit.dataset.id = "cp-submit";
    submit.type = "submit";
    submit.value = "Cambia password";
    submit.addEventListener("click", formCheck);
    form.appendChild(submit);
    box.appendChild(form);
}
function showDetails(event) {
    const span = event.currentTarget;
    const div = span.parentNode.querySelector(".details-div");
    div.classList.remove("hidden");
    span.innerHTML = "";
    span.textContent = "Riduci";
    span.removeEventListener("click", showDetails);
    span.addEventListener("click", hideDetails);
}
function hideDetails(event) {
    const span = event.currentTarget;
    const div = span.parentNode.querySelector(".details-div");
    div.classList.add("hidden");
    span.innerHTML = "";
    span.textContent = "Dettagli";
    span.removeEventListener("click", hideDetails);
    span.addEventListener("click", showDetails);
}
function showPurchasesView() {
    const box = document.querySelector("#right-side-box");
    const dbox = document.querySelector("#d-box");
    if (dbox !== null)
        return;
    box.innerHTML = "";
    if (("error" in data)) {
        //L'utente non ha effettuato acquisti
        const div = document.createElement("div");
        div.dataset.id = "nt-box";
        const message = document.createElement("span");
        message.dataset.id = "No-transaction-message";
        message.textContent = "Non hai ancora effettuato alcuna transazione";
        div.appendChild(message);
        box.appendChild(div);
        return;
    }
    for (transaction of data) {
        const div = document.createElement("div");
        div.classList.add("dinamyc-box");
        const cbox = document.createElement("div");
        cbox.classList.add("content-box");
        const div2 = document.createElement("div");
        div2.classList.add("data-box-standard");
        const div3 = document.createElement("div");
        div3.classList.add("data-box");
        const span = document.createElement("span");
        span.classList.add("click-span");
        span.textContent = "Dettagli";
        span.addEventListener("click", showDetails);
        const spanId = document.createElement("span");
        spanId.textContent = "Id transazione :";
        spanId.classList.add("data-span");
        const spanData = document.createElement("span");
        spanData.classList.add("data-span");
        spanData.textContent = "Data :";
        const spanTot = document.createElement("span");
        spanTot.classList.add("data-span");
        spanTot.textContent = "Totale pagato :";
        const spanM = document.createElement("span");
        spanM.classList.add("data-span");
        spanM.textContent = "Metodo pagamento :";
        const spanNM = document.createElement("span");
        spanNM.classList.add("data-span");
        spanNM.textContent = "N.Met. pagamento :";
        const spand = document.createElement("span");
        spand.classList.add("data-span");
        spand.textContent = transaction.Id;
        const spand2 = document.createElement("span");
        spand2.classList.add("data-span");
        spand2.textContent = transaction.Data;
        const spand3 = document.createElement("span");
        spand3.classList.add("data-span");
        spand3.textContent = transaction.Importo + "€";
        const spand4 = document.createElement("span");
        spand4.classList.add("data-span");
        spand4.textContent = transaction.Metodo;
        const spand5 = document.createElement("span");
        spand5.classList.add("data-span");
        spand5.textContent = transaction["Num.Metodo"];
        const hdiv = document.createElement("div");
        hdiv.classList.add("details-div");
        hdiv.classList.add("hidden");
        div2.appendChild(spanId);
        div2.appendChild(spanData);
        div2.appendChild(spanTot);
        div2.appendChild(spanM);
        div2.appendChild(spanNM);
        div3.appendChild(spand);
        div3.appendChild(spand2);
        div3.appendChild(spand3);
        div3.appendChild(spand4);
        div3.appendChild(spand5);
        cbox.appendChild(div2);
        cbox.appendChild(div3);
        div.appendChild(cbox);
        div.appendChild(span);
        div.appendChild(hdiv);
        const products = transaction.Prodotti;
        if (Array.isArray(products))
            for (let i = 0; i < products.length; i++) {
                const string = products[i];
                const d = string.split(",");
                const spanp = document.createElement("span");
                spanp.classList.add("span-p");
                spanp.textContent = d[0] + " : " + d[1];
                hdiv.appendChild(spanp);
            }
        else {
            const string = products;
            const d = string.split(",");
            const spanp = document.createElement("span");
            spanp.classList.add("span-p");
            spanp.textContent = d[0] + " : " + d[1];
            hdiv.appendChild(spanp);
        }
        box.appendChild(div);
    }
}
function resume(event) {
    const box = event.currentTarget.parentNode.parentNode.parentNode;
    box.classList.add("hidden");
    document.body.classList.remove("no-scroll");
}
function showLogoutConfirm() {
    const a = document.querySelector(".lbox");
    if (a === null) {
        //il box non esiste
        const ext_box = document.createElement("div");
        ext_box.classList.add("lbox");
        const box = document.createElement("div");
        box.dataset.id = "logout-box";
        const img_box = document.createElement("div");
        img_box.dataset.id = "log-subbox";
        const img = document.createElement("img");
        img.src = "img/common/close.png";
        img.dataset.id = "logout-img";
        img.addEventListener("click", resume);
        const message = document.createElement("div");
        message.dataset.id = "logout-message";
        message.textContent = "Verrai disconnesso dal tuo account,vuoi procedere comunque?";
        const a = document.createElement("a");
        a.textContent = "Procedi";
        a.href = "logout.php";
        a.dataset.id = "logout-link";
        box.appendChild(img_box);
        img_box.appendChild(img);
        box.appendChild(message);
        box.appendChild(a);
        ext_box.appendChild(box);
        document.body.appendChild(ext_box);
    }
    else {
        //il box già esiste
        a.classList.remove("hidden");
        document.body.classList.add("no-scroll");
    }
}

const spans = document.querySelectorAll(".option");
for (span of spans) {
    if (span.dataset.id === "purchase")
        span.addEventListener("click", showPurchasesView);
    if (span.dataset.id === "change-password")
        span.addEventListener("click", showChangePasswordView);
    if (span.dataset.id === "logout")
        span.addEventListener("click", showLogoutConfirm);
}
//Variabile che contiene le informazioni sulle transazioni per non doverle richiedere più di una volta
let data;
function onResponse(response) {
    return response.json();
}
function onError(error) {
    return console.log(error);
}
function getData(json) {
    console.log(json);
    data = json;
    showPurchasesView();
}
const user = document.body.dataset.id;
const formdata = new FormData();
formdata.append("user", user);
fetch("fetch_userPurchases.php", { method: "post", body: formdata }).then(onResponse, onError).then(getData);

function removeBox(event) {
    const box = event.currentTarget.parentNode.parentNode;
    box.remove();
    showChangePasswordView();
    document.body.classList.remove("no-scroll");
}
const close = document.querySelector("#dbox-img");
if (close !== null) {
    close.addEventListener("click", removeBox);
}


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
