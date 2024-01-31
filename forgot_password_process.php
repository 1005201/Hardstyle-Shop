<?php

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
} else {
    exit();
}

/*require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';*/

try {

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP(true);
    $mail->Host = 'smtp-mail.outlook.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lovenetfish@outlook.com';
    $mail->Password = 'netfish22';
    $mail->SMTPSecure = "TLS";
    $mail->Port = 587;


    $mail->setFrom('lovenetfish@outlook.com', 'Netfish');

    $mail->addAddress($email);

    $token = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);


    $mail->isHTML(true);
    $mail->Subject = 'Password Reset';
    $mail->Body = 'To reset your password click <a href="http://localhost/progvaardigheden/Netfish/reset.php?code=' . $token . '">here </a>. </br>Reset your password in a day.';

    $conn = new mySqli('localhost', 'root', '', 'netfish');

    if ($conn->connect_error) {
        die('Could not connect to the database.');
    }

    $verifyQuery = $conn->query("SELECT * FROM user WHERE email = '$email'");

    if ($verifyQuery->num_rows) {
        $codeQuery = $conn->query("UPDATE user SET code = '$token' WHERE email = '$email'");

        $mail->send();
        echo 'Message has been sent, check your email';
    }
    $conn->close();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
