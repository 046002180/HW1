<?php
require_once "query.php";
session_start();
if (!isset($_SESSION["lambda_user"])) {
    header("Location:login.php");
    exit;
}
if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['new_password2'])) {
    $password_pattern_number_control = '/^(?=.*[0-9])[A-Za-z0-9@$!%*#?&§^_"£=€°{}\[\[\]\|\-\(\)]{8,16}$/';
    $password_pattern_special_character_control = '/^(?=.*[@$!%*#?&§^_"£=€°{}\[\]\|\-\(\)])[A-Za-z0-9@$!%*#?&§^_"£=€°{}\[\[\]\|\-\(\)]{8,16}$/';
    if (
        !preg_match($password_pattern_number_control, $_POST['current_password'])
        || !preg_match($password_pattern_special_character_control, $_POST['current_password'])
    ) {
        $error = true;
        $password_error = "Password corrente errata"; //La password corrente ha già passato gli stessi controlli nella procedura di signup
    } elseif (strcmp($_POST['new_password'], $_POST['new_password2']) !== 0) {
        $error = true;
        $password_error = 'Le password inserite non coincidono.';
    } elseif (strlen($_POST['new_password']) < 8) {
        $error = true;
        $password_error = 'Password troppo corta.';
    } elseif (strlen($_POST['new_password']) > 16) {
        $error = true;
        $password_error = 'Password troppo lunga.';
    } elseif (!preg_match($password_pattern_number_control, $_POST['new_password'])) {
        $error = true;
        $password_error = 'La password non contiene numeri.';
    } elseif (!preg_match($password_pattern_special_character_control, $_POST['new_password'])) {
        $error = true;
        $password_error = 'La password non contiene caratteri speciali.';
    } else {
        //Le password sono state accettate
        $conn = mysqli_connect("localhost", "root", "", "hmw") or die("Error : " . mysqli_error($conn));
        $email = mysqli_real_escape_string($conn, $_SESSION['lambda_user']);
        $old_password = mysqli_real_escape_string($conn, $_POST['current_password']);
        $old_password = hash("sha256", $old_password, false);
        $old_password = base64_encode($old_password);
        $query_old_password = create_getPasswordQuery($email);
        $res = mysqli_query($conn, $query_old_password) or die("Error : " . mysqli_error($conn));
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_row($res);
            $old_stored_password = $row[0];
            if (strcmp($old_password, $old_stored_password) === 0) {
                //password esatta
                $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
                $new_password = hash("sha256", $new_password, false);
                $new_password = base64_encode($new_password);
                $query = create_changePasswordQuery($email, $new_password);
                $res = mysqli_query($conn, $query) or die("Error : " . mysqli_error($conn));
                if ($res) {
                    //query effettuata correttamente
                    $Password_changed = true;  
                } else {
                    $Password_changed = false;
                }
                mysqli_close($conn);
            }else{
            $error=true;
            $password_error = 'Password errata';
            }
        }
    }
}

?>
<html>

<head>
    <title>Area utente</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Cinzel&family=Dela+Gothic+One&family=Kanit&family=Prompt&family=Righteous&family=Teko&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="userarea.css">
    <script src="userarea.js" defer></script>
</head>

<body data-id=<?php echo "'" . $_SESSION['lambda_user'] . "'"; ?> <?php if (isset($Password_changed) || isset($error)) {
                                                                    echo "class='no-scroll'";
                                                                } ?>>
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
            <a class="long-menu-link" href="prodotti.html">Prodotti</a>
            <a class="long-menu-link" href="sedi.html">Sedi</a>
            <a class="long-menu-link" href="partner.html">Partner</a>
        </div>
    </div>
    <main id="general">
        <div id="user-box">
            <div id="left-side-box">
                <span class="option" data-id="purchase">I tuoi acquisti</span>
                <span class="option" data-id="change-password">Cambia password</span>
                <span class="option" data-id="logout">Logout</span>
            </div>
            <div id="right-side-box">
            <?php if (isset($Password_changed)) {
                    echo  "<div id='d-box'>
                    <div id='dbox-b'><img id='dbox-img' src='img/common/close.png'/></div>
                    <div id='dbox-msg'>";
                    if ($Password_changed) echo "Password aggiornata correttamente";
                    else echo "Errore: password non aggiornata</div></div";
                }
                ?>
                <?php if (isset($error)) {
                    echo  "<div id='d-box'>
                    <div id='dbox-b'><img id='dbox-img' src='img/common/close.png'/></div>
                    <div id='dbox-msg'>$password_error</div></div";
                }
                ?>
                <!-- I contenuti vanno aggiunti dinamicamente tramite javascript in questo box -->
            </div>
        </div>
    </main>
</body>

</html>