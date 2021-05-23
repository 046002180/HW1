<?php
require_once 'cookieContentExtractor.php';
require_once 'query.php';
session_start();
if (!isset($_SESSION['lambda_user'])) {
    header('Location:login.php');
    exit;
}
if (!isset($_COOKIE['cartcookie'])) {
    //Accesso alla pagina con carrello vuoto
    header('Location:prodotti.php');
    exit;
} else {
    $prodotti = ExtractContent($_COOKIE['cartcookie']);
    if (
        !empty($_POST['numero_copie']) && !empty($_POST['metodo_pagamento']) && !empty($_POST['numero_metpagamento'])
        && !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['codice'])
    ) {

        //FORM COMPILATO
        if (!preg_match('/.[A-Za-z]+/', $_POST['nome'])) {
            $error = true;
            $name_error = "Valore non ammesso";
        }
        if (!preg_match('/.[A-Za-z]+/', $_POST['cognome'])) {
            $error = true;
            $surname_error = "Valore non ammesso";
        }
        if (!preg_match('/.[A-Za-z]+/', $_POST['metodo_pagamento'])) {
            //I METODO DI PAGAMENTO SONO PREIMPOSTATI
            $error = true;
            $form_error = "Tentata manomissione";
        }
        if (!preg_match('/^(?!.*[a-zA-z])[0-9]+$/', $_POST['numero_metpagamento'])) {
            $error = true;
            $num_error = "Valore non ammesso";
        }
        if (!preg_match('/^(?!.*[a-zA-z])[0-9]+$/', $_POST['codice']) || (strlen($_POST['codice']) !== 3)) {
            $error = true;
            $code_error = "Codice CCV non ammissibile";
        }
        if (!isset($error)) {
            // QUERY AL DATABASE;

            $conn = mysqli_connect("localhost", "root", "", "hmw") or die("Errore: " . mysqli_error($conn));
            $email = mysqli_real_escape_string($conn, $_SESSION['lambda_user']);
            $method_payment = mysqli_real_escape_string($conn, $_POST['metodo_pagamento']);
            $name = mysqli_real_escape_string($conn, $_POST['nome']);
            $surname = mysqli_real_escape_string($conn, $_POST['cognome']);
            $num_p = mysqli_real_escape_string($conn, $_POST['numero_metpagamento']);
            $query = "DROP TEMPORARY TABLE IF EXISTS TMP;";
            $res = mysqli_query($conn, $query) or die("Errore: " . mysqli_error($conn));
            $query = "CREATE TEMPORARY TABLE TMP(Indice INTEGER,Software VARCHAR(30),N_copie INTEGER);";
            $res = mysqli_query($conn, $query) or die("Errore: " . mysqli_error($conn));
            $Index = 0;
            foreach ($_POST['numero_copie'] as $key => $value) {
                $value = mysqli_real_escape_string($conn, $value);
                $query = "INSERT INTO TMP VALUES($Index,$key,$value);";
                $res = mysqli_query($conn, $query) or die("Errore: " . mysqli_error($conn));
                $Index++;
            }
            $query = "CALL acquisto('$email','$method_payment','$name','$surname','$num_p');";
            $res = mysqli_query($conn, $query) or die("Errore: " . mysqli_error($conn));
            $transaction=true; 
            setcookie('cartcookie', '');
        }
    }
}
?>
<html>

<head>
    <title>Carrello</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Cinzel&family=Dela+Gothic+One&family=Kanit&family=Prompt&family=Righteous&family=Teko&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
    <script src="cart.js" defer></script>
</head>

<body <?php if(isset($transaction)){echo "class='no-scroll'";}?>>
    <h1 id="header">
        <a href="home.html" id="logo"></a>
        <nav id="navbar">
            <a class="nav_item" href="home.html">HOME</a>
            <a class="nav_item" href="prodotti.php">PRODOTTI</a>
            <a class="nav_item" href="sedi.html">SEDI</a>
            <a class="nav_item" href="partner.html">PARTNER</a>
            <a href="userarea.php"><img id="nav-icon" src="img/common/u-icon.png" /></a>
        </nav>
        <button id="small-menu">
            <img id="3-stripes" src="img/common/minimenu.png" />
        </button>
    </h1>
    <div id="long-menu" class='hidden'>
        <div id="lm-overlay"></div>
        <button id="lm-button">
            <img id="arrows" src="img/common/arrows.png" />
        </button>
        <div id="lm-box-link">
            <a class="long-menu-link" href="home.html">Home</a>
            <a class="long-menu-link" href="prodotti.php">Prodotti</a>
            <a class="long-menu-link" href="sedi.html">Sedi</a>
            <a class="long-menu-link" href="partner.html">Partner</a>
            <a class="long-menu-link" href="userarea.php">Area Personale</a>
        </div>
    </div>
    <main id="general">
    <?php if(isset($transaction)){
        echo "<div id='t-box'>
              <div id='t-message'>Transazione effettuata</div>
              <a id='t-link' href='userarea.php'>Ritorna all'area utente</a>
              </div>";
        exit;
    }?>
        <div id="err_box" class="hidden">
            <div id="eb_f"><img src="img/common/close.png" id="close-img" /></div>
            <div id="eb_message"></div>
        </div>
        </div>
        <div id="cart-box">
            <form method='post' id="form-box">
                <div id="products-box" class="box">
                </div>
                <div id="payment-data-box" class="box">
                    <label id="payment-method">Metodo di pagamento <select name="metodo_pagamento">
                            <option selected>Carta di credito</option>
                            <option>Carta prepagata</option>
                        </select>
                    </label>
                    <h2>Dati Intestatario</h2>
                    <?php if (isset($name_error)) {
                        echo "<span class='error-message'>$name_error</span>";
                    } ?>
                    <p class='label-p'>
                        <label>Nome <input type="text" name="nome"></label>
                    </p>
                    <?php if (isset($surname_error)) {
                        echo "<span class='error-message'>$surname_error</span>";
                    } ?>
                    <p class='label-p'>
                        <label>Cognome <input type="text" name="cognome"></label>
                    </p>
                    <?php if (isset($num_error)) {
                        echo "<span class='error-message'>$num_error</span>";
                    } ?>
                    <p class='label-p'>
                        <label>Numero Carta <input type="text" name="numero_metpagamento"></label>
                    </p>
                    <?php if (isset($code_error)) {
                        echo "<span class='error-message'>$code_error</span>";
                    } ?>
                    <p class='label-p'>
                        <label>CCV <input type="text" name="codice"></label>
                    </p>
                </div>
                <div id="price-box">
                    <span class="pbox-item">Totale:</span>
                </div>
                <div id="submit-box" class="box">
                    <label><input id="submit-input" type="submit" value="Paga"></label>
                </div>
            </form>
        </div>
    </main>
    <footer>
    <div id="stripe"></div>
    <div id="footer-box">
      <div id="mini-logo-box">
        <img src="img/common/minilogo.png" />
        <span id="azienda">Lambda software.spa</span></br>
        <span id="sede">Italy,Rome</span>
      </div>
      <div id="footer-links-box">
        <a class="link" href="chs.html">Chi siamo</a>
        <span class="vertical-stripe">|</span>
        <a class="link" href="lav.html">Lavora con noi</a>
        <span class="vertical-stripe">|</span>
        <a class="link" href="contatti.html">Contatti</a></br>
        <div id="box-social">
          <a id="instagram-link" class="social-logo" href="insprofile.html"></a>
          <a id="facebook-link" class="social-logo" href="fbprofile.html"></a>
          <a id="twitter-link" class="social-logo" href="twprofile.html"></a>
        </div>
        <span id="dati">CARLO PIO PACE Matricola:O46002180</span>
      </div>
    </div>
  </footer>
</body>

</html>