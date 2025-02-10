<?php
session_start();
$connessione = mysqli_connect("localhost", "root", "", "ticketone");

if (!$connessione) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['username'] ?? '';
$password = $_SESSION['password'] ?? '';

if (isset($_POST['login'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    if (!empty($_SESSION['username']) && !empty($_SESSION['password'])) {

        $stmt = mysqli_prepare($connessione, "SELECT * FROM tutenti WHERE mail = ? AND password = ?");

        if ($stmt === false) {
            die("Error preparing statement: " . mysqli_error($connessione));
        }

        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['username'], $_SESSION['password']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $arr = mysqli_fetch_array($result);
            $_SESSION['idUser'] = $arr['id'];
            $_SESSION['login'] = true;
            header('Location: index.php');
            exit;
        } else {
            $message = "User not found!";
        }
        mysqli_stmt_close($stmt);

    } else {
        $message = "Please provide both username and password!";
    }
}
mysqli_close($connessione);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header class="header">
        <a href="index.php">
            <div class="logo-container">
                <img class="logo" src="img/pngegg.png" alt="">
            </div>
        </a>
        <div class="intestazione-header">
            <h1>ticketONE</h1>
        </div>
    </header>
    <div class="body flex-1 display-flex flex-centered-container">
        <div class="container">
            <form class="login100-form" action="" method="POST" style="margin-bottom: 0px;">
                <span class="login100-form-title p-b-20">
                    Login
                </span>

                <div class="wrap-input100 m-b-23" data-validate="Username is reauired">
                    <span class="label-input100">Username</span>
                    <input class="input100" type="text" name="username" placeholder="Type your username">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password" placeholder="Type your password">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>

                </div>

                <div class="container-login100-form-btn" style="margin: 10px;">

                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <input class="login100-form-btn" type="submit" name="login" value="Login">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div>
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
    <footer class="footer container-login100-form-btn">
        <h5>serban razvan</h5>
    </footer>
</body>

</html>