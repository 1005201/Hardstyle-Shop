<?php

session_start();

require_once 'connection.php';
require_once 'user.php';

if (isset($_SESSION['user'])) {
    header("location: index.php");
}

if (isset($_REQUEST['login_button'])) {
    $email = filter_var(strtolower($_REQUEST['email']), FILTER_SANITIZE_EMAIL);
    $password = strip_tags($_REQUEST['wachtwoord']);

    if (empty($email)) {
        $errormsg[] = "voer een e-mailadres in";

    } elseif (empty($password)) {
        $errormsg[] = 'voer een password';
    } else {
        try {
            $select_stat = $conn->prepare(
                'SELECT * FROM user WHERE email = :email'
            );
            $select_stat->execute([':email' => $email]);
            $row = $select_stat->fetch(PDO::FETCH_ASSOC);
            if ($select_stat->rowCount() > 0) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user']['id'] = session_id();
                    $_SESSION['user']['username'] = $row['username'];
                    $_SESSION['user']['email'] = $row['email'];
                    $_SESSION['STATUS'] = "ACTIEF";
                    $_SESSION['user']['rol'] = $row['rol'];


                    header('location: index.php');
                } else {
                    $errormsg[] = 'verkeerde email/wachtwoord';
                }
            } else {
                $errormsg[] = 'verkeerde email/wachtwoord';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="stylen.css">
</head>
<body>

<main>
    <h1>Inloggen</h1>
    <form action="login.php" method="post" class="container">
        <div class="form-group">
            <div class="form-label">
                <label for="email"> E-mailadres</label>
            </div>
            <div class="form-input">
                <input required type="email" name="email" placeholder="example@example.com">
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                <label for="wachtwoord">Wachtwoord</label>
            </div>
            <div class="form-input">
                <input required type="password" name="wachtwoord" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                Geen account?
            </div>
            <div class="form-input">
                <a href="registration.php">Registeer een account</a>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                Wachtwoord vergeten?
            </div>
            <div class="form-input">
                <a href="forgot_password.html">Vergeten?</a>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="login_button">Login</button>
        </div>
    </form>
</main>

</body>
</html>