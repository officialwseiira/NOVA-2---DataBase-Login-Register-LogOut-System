<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'mailiniz@gmail.com';
    $mail->Password   = '-'; // Uygulama şifresi
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('mailiniz@gmail.com', 'Web Formu');
    $mail->addAddress('mailiniz@gmail.com'); //
    $mail->isHTML(true);
    $mail->Subject = 'Yeni Mesaj';
    $mail->Body    = 'Ad: ' . $_POST['name'] . '<br>Email: ' . $_POST['email'] . '<br>Mesaj: ' . $_POST['message'];

    $mail->send();
    echo 'Mesaj başarıyla gönderildi.';
} catch (Exception $e) {
    echo 'Mesaj gönderilemedi. Hata: ', $mail->ErrorInfo;
}
