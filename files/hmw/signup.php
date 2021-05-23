<?php
require_once 'query.php';

session_start();
if (isset($_SESSION['lambda_user'])) {
    header('Location:userarea.php');
    exit;
}
if (
    isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['stato']) && isset($_POST['citta']) &&
    isset($_POST['indirizzo']) && isset($_POST['numero']) && isset($_POST['email']) && isset($_POST['password']) &&
    isset($_POST['password2'])
) {

    // pattern completo $password_pattern='/^(?=.*[0-9])(?=.*[@$!%*#?&§^_"£=€°{}\[\]\|\-\(\)])[A-Za-z0-9@$!%*#?&§^_"£=€°{}\[\[\]\|\-\(\)]{8,16}$/';
    $password_pattern_number_control = '/^(?=.*[0-9])[A-Za-z0-9@$!%*#?&§^_"£=€°{}\[\[\]\|\-\(\)]{8,16}$/';
    $password_pattern_special_character_control = '/^(?=.*[@$!%*#?&§^_"£=€°{}\[\]\|\-\(\)])[A-Za-z0-9@$!%*#?&§^_"£=€°{}\[\[\]\|\-\(\)]{8,16}$/';
    if (strcmp($_POST['password'], $_POST['password2']) !== 0) {
        $error=true;
        $password_error = 'Le password inserite non coincidono.';
    } elseif (strlen($_POST['password']) < 8) {
        $error=true;
        $password_error = 'Password troppo corta.';
    } elseif (strlen($_POST['password']) > 16) {
        $error=true;
        $password_error = 'Password troppo lunga.';
    } elseif (!preg_match($password_pattern_number_control, $_POST['password'])) {
        $error=true;
        $password_error = 'La password non contiene numeri.';
    } elseif (!preg_match($password_pattern_special_character_control, $_POST['password'])) {
        $error=true;
        $password_error = 'La password non contiene caratteri speciali.';
    }
    //Controlla che sia effetivamente un numero civico
    if (!preg_match('/^(?!.*[a-zA-z])[0-9]+$/', $_POST['numero'])) {
        $error=true;
        $number_error = 'Numero non valido';
    }
    //Controlla che l'email inserita abbia un dominio valido
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error=true;
        $email_error = 'Mail non valida.';
    }
    if (!isset($error)) {
        $conn = mysqli_connect('localhost', 'root', '', 'hmw') or die("Errore:" . mysqli_connect_error());
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "SELECT * FROM cliente_privato WHERE email='$email'";
        $result = mysqli_query($conn, $query) or die("Errore:" . mysqli_error($conn));
        $row = mysqli_fetch_row($result);
        if ($row !== NULL){
            $email_error = 'Mail già in uso';
            mysqli_free_result($result);
        }
        else {
            //Registrazione dati nel database
            mysqli_free_result($result);
            //Funzione definita nel file query.php
            $query =create_signupQuery($conn,$_POST['email'],$_POST['password'],$_POST['nome'],$_POST['cognome'],$_POST['stato'], $_POST['citta'],$_POST['indirizzo'],$_POST['numero']); 
            $result = mysqli_query($conn, $query) or die("Errore:" . mysqli_error($conn));
            if ($result) {
                $_SESSION['lambda_user'] = $_POST['email'];
                mysqli_close($conn);
                mysqli_free_result($result);
                header('Location:userarea.php');
                exit;
            }
        }
        mysqli_close($conn);
    }
}
?>
<html>

<head>
    <title>SignUp</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Cinzel&family=Dela+Gothic+One&family=Kanit&family=Prompt&family=Righteous&family=Teko&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signup.css">
    <script src="signup.js" defer></script>
</head>

<body>
    <h1 id="header">
        <a href="home.html" id="logo"></a>
        <nav id="navbar">
            <a class="nav_item" href="home.html">HOME</a>
            <a class="nav_item" href="prodotti.php">PRODOTTI</a>
            <a class="nav_item" href="sedi.html">SEDI</a>
            <a class="nav_item" href="partner.html">PARTNER</a>
        </nav>
        <button id="small-menu">
            <img id="3-stripes" src="img/common/minimenu.png" />
        </button>
    </h1>
    <div id="long-menu">
        <div id="lm-overlay"></div>
        <button id="lm-button">
            <img id="arrows" src="img/common/arrows.png" />
        </button>
        <div id="lm-box-link">
            <a class="long-menu-link" href="home.html">Home</a>
            <a class="long-menu-link" href="prodotti.php">Prodotti</a>
            <a class="long-menu-link" href="sedi.html">Sedi</a>
            <a class="long-menu-link" href="partner.html">Partner</a>
        </div>
    </div>
    <main id="general">
        <div id="data-box">
            <h2>Inserisci i dati richiesti</h2>
            <?php if (isset($form_error)) {
                echo "<em class='error'>$error</em>";
            } ?>
            <form name="user-data" action="signup.php" method="post">
                <div id="ext-box">
                    <div class="info-box">
                        <p>
                            <label>Nome <input type="text" name="nome"></label>
                        </p>
                        <p>
                            <label>Stato <input type="text" name="stato"></label>
                        </p>
                        <p>
                            <label>Indirizzo <input type="text" name="indirizzo"></label>
                        </p>
                        <?php if (isset($email_error)) {
                            echo "<em class='error'>$email_error</em>";
                        } ?>
                        <p>
                            <label>Email <input type="text" name="email"></label>
                        </p>
                        <?php if (isset($password_error)) {
                            echo "<em class='error'>$password_error</em>";
                        } ?>
                        <p>
                            <label>Password <input type="password" name="password"></label>
                        </p>
                        <p>
                            <label>Conferma password <input type="password" name="password2"></label>
                        </p>
                    </div>
                    <div class="info-box">
                        <p>
                            <label>Cognome <input type="text" name="cognome"></label>
                        </p>
                        <p>
                            <label>Città<input type="text" name="citta"></label>
                        </p>
                        <?php if (isset($number_error)) {
                            echo "<em class='error'>$number_error</em>";
                        } ?>
                        <p>
                            <label>N. <input type="text" name="numero"></label>
                        </p>
                        <p class="advice">
                            <em>Inserisci un'email che usi regolarmente, riceverai lì le</em></br>
                            <em>le nostre comunicazioni.</em></br>
                        </p>
                        <p class="advice">
                            <em>La password deve contenere almeno 8 (max 16) caratteri</em></br>
                            <em>di cui almeno un numero e un carattere speciale (es. @,#,!).</em>
                        </p>
                    </div>
                </div>
                <p>
                    <label id="submit-label"><input type="submit" value="Registrati"></label>
                </p>
            </form>
            <a href="login.php">Ho già un account</a>
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