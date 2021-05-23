<?php
require_once 'query.php';
session_start();
if (isset($_SESSION['lambda_user'])) {
    header('Location:userarea.php');
    exit;
}
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    //I dati sono stati inseriti
    $conn = mysqli_connect("localhost", "root", "", "hmw") or die("Errore:" . mysqli_error($conn));
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query = create_getPasswordQuery($email);
    $result = mysqli_query($conn, $query) or die("Errore:" . mysqli_error($conn));
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_object($result);
        $password=base64_encode(hash("sha256",$password,false));
        if (strcmp($password,$row->password)===0) {
            //La password è corretta
            $_SESSION['lambda_user']=$_POST['email'];
            mysqli_close($conn);
            mysqli_free_result($result);
            header('Location:userarea.php');
            exit;
        }
        
        //La password è sbagliata
        $message = 'Password errata';
    } else {
        $message = 'Email non presente';
    }
} elseif (!empty($_POST['email'])) {
    $message = 'Inserisci la password';
} elseif (!empty($_POST['password'])) {
    $message = "Inserisci l'username";
}
?>


<html>

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Cinzel&family=Dela+Gothic+One&family=Kanit&family=Prompt&family=Righteous&family=Teko&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <script src="login.js" defer></script>
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
            <a class="long-menu-link" href="home.php">Home</a>
            <a class="long-menu-link" href="prodotti.php">Prodotti</a>
            <a class="long-menu-link" href="sedi.html">Sedi</a>
            <a class="long-menu-link" href="partner.html">Partner</a>
        </div>
    </div>
    <main id="general">
        <div id="login-box">
            <h2>Accedi all'area riservata</h2>
            <?php if (isset($message)) {
                echo "<span id='errore'>$message</span>";
            } ?>
            <form name="login" method="post">
                <p>
                    <label>Email <input type="text" name="email"></label>
                </p>
                <p>
                    <label>Password <input type="password" name="password"></label>
                </p>
                <p>
                    <label id="submit-label"><input type="submit" value="Log-in"></label>
                </p>
            </form>
            <a href="signup.php">Iscriviti</a>
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