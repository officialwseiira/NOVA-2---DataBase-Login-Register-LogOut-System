<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: giris.php");
    exit;
}

// Veritabanı bağlantısı
$host = "localhost";
$dbname = "site_uyelik";
$username_db = "root";
$password_db = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username_db, $password_db);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

// Kullanıcı bilgilerini al
$stmt = $db->prepare("SELECT * FROM uyeler WHERE kullanici_adi = ?");
$stmt->execute([$_SESSION["user"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Varsayılan profil resmi
$avatar = (!empty($user["profil_resmi"]) && file_exists($user["profil_resmi"])) 
    ? $user["profil_resmi"] 
    : "./profiles/image.png";

$message = "";
$error = "";

// Nick güncelle
if (isset($_POST["change_nick"])) {
    $newNick = trim($_POST["new_nick"]);
    if ($newNick) {
        $update = $db->prepare("UPDATE uyeler SET kullanici_adi = ? WHERE id = ?");
        $update->execute([$newNick, $user["id"]]);
        $_SESSION["user"] = $newNick;
        $message = "Kullanıcı adınız güncellendi.";
    }
}

// Email güncelle
if (isset($_POST["change_email"])) {
    $newEmail = trim($_POST["new_email"]);
    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $update = $db->prepare("UPDATE uyeler SET email = ? WHERE id = ?");
        $update->execute([$newEmail, $user["id"]]);
        $message = "E-posta adresiniz güncellendi.";
    } else {
        $error = "Geçerli bir e-posta girin.";
    }
}

// Şifre güncelle
if (isset($_POST["change_password"])) {
    $oldPass = $_POST["old_pass"];
    $newPass = $_POST["new_pass"];
    if (password_verify($oldPass, $user["sifre"])) {
        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        $update = $db->prepare("UPDATE uyeler SET sifre = ? WHERE id = ?");
        $update->execute([$hash, $user["id"]]);
        $message = "Şifreniz güncellendi.";
    } else {
        $error = "Mevcut şifreniz yanlış.";
    }
}

// Profil resmi güncelle
if (isset($_POST["change_avatar"]) && isset($_FILES["avatar"])) {
    $file = $_FILES["avatar"];
    if ($file["error"] === 0) {
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $allowed = ["jpg", "jpeg", "png", "gif"];
        if (in_array(strtolower($ext), $allowed)) {
            $filename = "uploads/" . uniqid() . "." . $ext;
            move_uploaded_file($file["tmp_name"], $filename);
            $update = $db->prepare("UPDATE uyeler SET profil_resmi = ? WHERE id = ?");
            $update->execute([$filename, $user["id"]]);
            $message = "Profil resminiz güncellendi.";
            $avatar = $filename;
        } else {
            $error = "Sadece JPG, PNG, GIF yükleyebilirsiniz.";
        }
    }
}

// Güncel bilgileri tekrar al
$stmt = $db->prepare("SELECT * FROM uyeler WHERE id = ?");
$stmt->execute([$user["id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kontrol Paneli — wSeiira</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    .profile-header {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 24px;
    }
    .profile-header img {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      object-fit: cover;
    }
    .settings-form {
      display: grid;
      gap: 30px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      box-shadow: var(--shadow);
    }
    .settings-form h3 {
      margin: 0 0 8px;
      font-size: 18px;
    }
    /* Floating label */
    .form-group {
      position: relative;
      margin-bottom: 15px;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 14px 12px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      background: var(--card);
      font-size: 15px;
      outline: none;
      transition: all 0.2s ease;
    }
    .form-group label {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 14px;
      pointer-events: none;
      transition: all 0.2s ease;
    }
    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: 4px;
      font-size: 12px;
      color: var(--brand);
    }
    .form-group input:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(79, 209, 197, 0.25);
    }
    /* File input */
    input[type="file"] {
      display: block;
      padding: 8px;
      border: 1px dashed var(--border);
      border-radius: var(--radius);
      background: var(--card);
      cursor: pointer;
      font-size: 14px;
      transition: border-color 0.2s;
    }
    input[type="file"]:hover {
      border-color: var(--brand);
    }
  </style>
</head>
<body>

<header class="nav">
    <a class="brand" href="./index.php">
      <svg aria-hidden="true" width="28" height="28" viewBox="0 0 24 24" class="logo"><path d="M12 2l3.09 6.26L22 9.27l-5 4.9L18.18 22 12 18.77 5.82 22 7 14.17l-5-4.9 6.91-1.01L12 2z"/></svg>
      wSeiira
    </a>

    <!-- CSS-only açılır menü -->
    <input id="menu-toggle" type="checkbox" class="menu-toggle" aria-label="Menüyü Aç/Kapat">
    <label for="menu-toggle" class="menu-button" aria-hidden="true"></label>

    <nav class="menu">
      <a href="./index.php">Ana Sayfa</a>
      <a href="./info.php">Hakkımda</a>
      <a href="./contact.php">İletişim</a>
      <a href="./logout.php">Çıkış Yap</a>
      <a href="./dashboard.php" class="btn ghost">Dashboard</a>
    </nav>
  </header>

<section class="section">
  <div class="container">
    <div class="profile-header">
      <img src="<?= htmlspecialchars($avatar) ?>" alt="Profil Resmi">
      <div>
        <h2>Hoşgeldin <b><em><u><?= htmlspecialchars($user["kullanici_adi"]) ?></b></em></u> , burası senin kontrol panelin.</h2>
        <p class="muted"><?= htmlspecialchars($user["email"]) ?></p>
      </div>
    </div>

    <?php if ($error): ?><p style="color:#ff6b6b;font-weight:600;"><?= $error ?></p><?php endif; ?>
    <?php if ($message): ?><p style="color:#4fd1c5;font-weight:600;"><?= $message ?></p><?php endif; ?>

    <!-- Nick -->
<form class="settings-form" method="post">
  <h3>Kullanıcı Adı</h3>
  <div class="form-group">
    <input type="text" name="new_nick" value="<?= htmlspecialchars($user["kullanici_adi"]) ?>" placeholder=" " required>
    <label for="new_nick">Yeni Kullanıcı Adı</label>
  </div>
  <button class="btn primary" type="submit" name="change_nick">Güncelle</button>
</form>

<!-- Email -->
<form class="settings-form" method="post">
  <h3>E-posta</h3>
  <div class="form-group">
    <input type="email" name="new_email" value="<?= htmlspecialchars($user["email"]) ?>" placeholder=" " required>
    <label for="new_email">Yeni E-posta</label>
  </div>
  <button class="btn primary" type="submit" name="change_email">Güncelle</button>
</form>

<!-- Şifre -->
<form class="settings-form" method="post">
  <h3>Şifre Değiştir</h3>
  <div class="form-group">
    <input type="password" name="old_pass" placeholder=" " required>
    <label for="old_pass">Mevcut Şifre</label>
  </div>
  <div class="form-group">
    <input type="password" name="new_pass" placeholder=" " required>
    <label for="new_pass">Yeni Şifre</label>
  </div>
  <button class="btn primary" type="submit" name="change_password">Güncelle</button>
</form>

<!-- Profil Resmi -->
<form class="settings-form" method="post" enctype="multipart/form-data">
  <h3>Profil Resmi</h3>
  <input type="file" name="avatar" required>
  <button class="btn primary" type="submit" name="change_avatar">Yükle</button>
</form>

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

<script>
  document.getElementById('yil').textContent = new Date().getFullYear();
</script>
</body>
</html>
