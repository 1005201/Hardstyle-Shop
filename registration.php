<?php

require_once 'connection.php';
require_once 'user.php';

session_start();
if (isset($_SESSION['user'])) {
    header('location: index.php');
}

if (isset($_REQUEST['register_btn'])) {
    $name = $_REQUEST['name'];
    $email = strtolower($_REQUEST['email']);
    $password = strip_tags($_REQUEST['password']);


    if (empty($name)) {
        $errorMsg[0][] = 'Voer je naam in';
    }
    if (empty($email)) {
        $errorMsg[1][] = 'Voer je e-mailadres in';
    }
    if (empty($password)) {
        $errorMsg[2][] = 'Voer je wachtwoord in';
    }
    if (strlen($password) < 6) {
        $errorMsg[2][] = 'Je wachtwoord moet minstend 6 tekens lang zijn';
    }

    if (empty($errorMsg)) {
        try {
            $select_stat = $conn->prepare(
                'SELECT username ,email FROM user WHERE email = :email'
            );
            $select_stat->execute([':email' => $email]);
            $row = $select_stat->fetch(PDO::FETCH_ASSOC);

            if (isset($row['email']) == $email) {
                $errorMsg[1][] = 'Dit e-mailadres is al ingebruik';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $created = new DateTime();
                $created = $created->format('Y-m-d H:i:s');

                $instert_stat = $conn->prepare(
                    'INSERT INTO user (username,email,password,rol) VALUES (:username,:email,:password,:rol)'
                );

                if (
                    $instert_stat->execute([
                        ':username' => $name,
                        ':email' => $email,
                        ':password' => $hashed_password,
                        ':rol' => 0,
                    ])
                ) {
                    header('location: login.php');
                }
            }
        } catch (PDOException $e) {
            $pdoError = $e->getMessage();
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
    <h1>Registreren</h1>
    <form action="registreer.php" method="post">
        <div class="form-group">
            <div class="form-label">
                <?php if (isset($errorMsg[1])) {
                    foreach ($errorMsg[1] as $emailErrors) {
                        echo '<p class="small  text-danger">' .
                            $emailErrors .
                            '</p>';
                    }
                } ?>
                <label for="email" class="form-label">E-mailadres</label>
            </div>
            <div class="form-input">
                <input type="email" name="email" class="form-control" placeholder="example@example.com">
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                <?php if (isset($errorMsg[2])) {
                    foreach ($errorMsg[2] as $passwordErrors) {
                        echo '<p class="small  text-danger">' .
                            $passwordErrors .
                            '</p>';
                    }
                } ?>
                <label for="password" class="form-label">Wachtwoord</label>
            </div>
            <div class="form-input">
                <input type="password" name="password" class="form-control" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">
                <?php if (isset($errorMsg[0])) {
                    foreach ($errorMsg[0] as $nameErrors) {
                        echo '<p class="small  text-danger">' .
                            $nameErrors .
                            '</p>';
                    }
                } ?>
                <label for="name" class="form-label">Naam</label>
            </div>
            <div class="form-input">
                <input type="text" name="name" class="form-control" placeholder="Voor- en achternaam">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
        </div>
    </form>
    <div class="form-group">
        <div class="form-label">
            Heb je al een account?
        </div>
        <div class="form-input">
            <a class="register" href="login.php">Log dan hier in!</a>
        </div>
    </div>
</main>

</body>
</html>