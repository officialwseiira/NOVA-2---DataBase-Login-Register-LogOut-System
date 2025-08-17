<?php
session_start();
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Veritabanı bağlantısı
$host = "localhost";
$dbname = "site_uyelik";
$username_db = "root"; // kendi kullanıcı adın
$password_db = "";     // kendi şifren

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username_db, $password_db);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

$step = 1; // 1: kullanıcı adı, 2: kod doğrulama, 3: yeni şifre
$message = "";
$error = "";

// 1. ADIM — Kullanıcı adını girip kod gönderme
if (isset($_POST["send_code"])) {
    $username = trim($_POST["username"] ?? "");

    if ($username) {
        $stmt = $db->prepare("SELECT * FROM uyeler WHERE kullanici_adi = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && !empty($user["email"])) {
            $code = rand(100000, 999999);
            $expires = date("Y-m-d H:i:s", strtotime("+15 minutes"));

            $update = $db->prepare("UPDATE uyeler SET reset_code = ?, reset_expires = ? WHERE id = ?");
            $update->execute([$code, $expires, $user["id"]]);
            

$mail = new PHPMailer(true);
try {
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'whoiswseiira@gmail.com'; // Gmail adresin
    $mail->Password   = 'ccmglbwuxxgzzehb';       // Gmail uygulama şifresi
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('whoiswseiira@gmail.com', 'wSeiira Destek');
    $mail->addAddress($user["email"], $user["kullanici_adi"]);

    $mail->isHTML(true);
    $mail->Subject = 'Şifre Sıfırlama Kodunuz';
    $mail->Body    = "Merhaba {$user['kullanici_adi']},<br><br>Şifre sıfırlama kodunuz: <b>{$code}</b><br>Bu kod 15 dakika geçerlidir.";
    $mail->AltBody = "Şifre sıfırlama kodunuz: {$code}";

    $mail->send();
} catch (Exception $e) {
    $error = "E-posta gönderilemedi. Hata: {$mail->ErrorInfo}";
}


            // Basit mail gönderme (PHP mail() ile)
            $subject = "Şifre Sıfırlama Kodunuz";
            $body = "Merhaba {$user['kullanici_adi']},\n\nŞifre sıfırlama kodunuz: {$code}\nKod 15 dakika boyunca geçerlidir.";
            @mail($user["email"], $subject, $body);

            $_SESSION["reset_user"] = $user["kullanici_adi"];
            $message = "Kod e-posta adresinize gönderildi.";
            $step = 2;
        } else {
            $error = "Kullanıcı bulunamadı veya e-posta kayıtlı değil.";
        }
    } else {
        $error = "Lütfen kullanıcı adınızı girin.";
    }
}

// 2. ADIM — Kod doğrulama
if (isset($_POST["verify_code"])) {
    $code = trim($_POST["code"] ?? "");
    $username = $_SESSION["reset_user"] ?? "";

    if ($username && $code) {
        $stmt = $db->prepare("SELECT * FROM uyeler WHERE kullanici_adi = ? AND reset_code = ?");
        $stmt->execute([$username, $code]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (strtotime($user["reset_expires"]) > time()) {
                $_SESSION["reset_verified"] = true;
                $step = 3;
            } else {
                $error = "Kodun süresi dolmuş.";
                $step = 1;
            }
        } else {
            $error = "Kod hatalı.";
            $step = 2;
        }
    }
}

// 3. ADIM — Yeni şifre belirleme
if (isset($_POST["set_password"])) {
    $newPass = trim($_POST["password"] ?? "");
    $username = $_SESSION["reset_user"] ?? "";

    if ($_SESSION["reset_verified"] && $newPass && $username) {
        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        $update = $db->prepare("UPDATE uyeler SET sifre = ?, reset_code = NULL, reset_expires = NULL WHERE kullanici_adi = ?");
        $update->execute([$hash, $username]);

        unset($_SESSION["reset_user"], $_SESSION["reset_verified"]);
        $message = "Şifreniz başarıyla güncellendi. Giriş yapabilirsiniz.";
        $step = 1;
    } else {
        $error = "Şifre belirlenemedi.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Şifre Sıfırlama — wSeiira</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

<header class="nav">
  <a class="brand" href="#">wSeiira</a>
</header>

<section class="section" style="min-height: calc(100vh - 120px); display: flex; align-items: center;">
  <div class="container" style="max-width: 420px; width: 100%;">
    <h2 class="section-title">Şifre Sıfırlama</h2>

    <?php if ($error): ?>
      <p style="color:#ff6b6b; font-weight:600;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($message): ?>
      <p style="color:#4fd1c5; font-weight:600;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form class="card form" method="post">
      <?php if ($step === 1): ?>
        <label class="full">
          <span>Kullanıcı Adı</span>
          <input type="text" name="username" placeholder="Kullanıcı adınız" required>
        </label>
        <button class="btn primary" type="submit" name="send_code">Kodu Gönder</button>

      <?php elseif ($step === 2): ?>
        <label class="full">
          <span>E-postanıza gelen kod</span>
          <input type="text" name="code" placeholder="6 haneli kod" required>
        </label>
        <button class="btn primary" type="submit" name="verify_code">Kodu Doğrula</button>

      <?php elseif ($step === 3): ?>
        <label class="full">
          <span>Yeni Şifre</span>
          <input type="password" name="password" placeholder="Yeni şifre" required>
        </label>
        <button class="btn primary" type="submit" name="set_password">Şifreyi Kaydet</button>
      <?php endif; ?>
    </form>

    <p style="text-align:center; margin-top:10px;">
      <a href="giris.php" style="color:var(--brand);">Giriş sayfasına dön</a>
    </p>
  </div>
</section>

<footer class="footer">
    <div class="container foot-grid">
      <div>
        <a class="brand small" href="#">wSeiira</a>
        <p class="muted">© <span id="yil"></span> wSeiira. Tüm hakları saklıdır.</p>
      </div>
      <nav class="foot-links">
        <a href="https://instagram.com/jstwseiira" target="_blank" class="insta-link">
      <i class="fab fa-instagram"></i> JstwSeiira</a>
      </nav>
    </div>
  </footer>

<script>document.getElementById('yil').textContent = new Date().getFullYear();</script>
</body>
</html>
