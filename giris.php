<?php
session_start();

// Eğer kullanıcı zaten giriş yaptıysa dashboard'a yönlendir
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}

// Veritabanı bağlantısı
$host = "localhost";
$dbname = "site_uyelik";
$username_db = "root";
$password_db = "";

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

$error = "";
$success = "";

// Kayıt
if (isset($_POST["register"])) {
    $username = trim($_POST["reg_username"] ?? "");
    $password = trim($_POST["reg_password"] ?? "");

    if ($username && $password) {
        $stmt = $db->prepare("SELECT id FROM uyeler WHERE kullanici_adi = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Bu kullanıcı adı zaten alınmış.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO uyeler (kullanici_adi, sifre) VALUES (?, ?)");
            if ($stmt->execute([$username, $hash])) {
                $success = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
            } else {
                $error = "Kayıt sırasında bir hata oluştu.";
            }
        }
    } else {
        $error = "Lütfen tüm alanları doldurun.";
    }
}

// Giriş
if (isset($_POST["login"])) {
    $username = trim($_POST["log_username"] ?? "");
    $password = trim($_POST["log_password"] ?? "");

    if ($username && $password) {
        $stmt = $db->prepare("SELECT * FROM uyeler WHERE kullanici_adi = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["sifre"])) {
            $_SESSION["user"] = $user["kullanici_adi"];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Kullanıcı adı veya şifre hatalı!";
        }
    } else {
        $error = "Lütfen tüm alanları doldurun.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Üyelik Sistemi — wSeiira</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    /* Form geçiş stili */
    .auth-container {
      position: relative;
      max-width: 420px;
      margin: auto;
      overflow: hidden;
    }
    .form-wrapper {
      display: flex;
      transition: transform 0.5s ease-in-out;
      width: 200%; /* iki form yan yana */
    }
    .form-box {
      width: 50%;
      padding: 20px;
    }
    .switch-links {
      text-align: center;
      margin-top: 12px;
      font-size: 14px;
      color: var(--muted);
    }
    .switch-links a {
      color: var(--brand);
      cursor: pointer;
    }
  </style>
</head>
<body>
 <header class="nav">
    <a class="brand" href="./index.php">
      <svg aria-hidden="true" width="28" height="28" viewBox="0 0 24 24" class="logo"><path d="M12 2l3.09 6.26L22 9.27l-5 4.9L18.18 22 12 18.77 5.82 22 7 14.17l-5-4.9 6.91-1.01L12 2z"/></svg>
      wSeiira
    </a>

    <input id="menu-toggle" type="checkbox" class="menu-toggle" aria-label="Menüyü Aç/Kapat">
    <label for="menu-toggle" class="menu-button" aria-hidden="true"></label>

    <nav class="menu">
      <a href="./index.php">Ana Sayfa</a>
      <a href="./info.php" >Hakkımda</a>
      <a href="./contact.php" >İletişim</a>
      <a href="./giris.php" class="btn ghost" >Giriş Yap</a>
    </nav>
  </header>

<section class="section" style="min-height: calc(100vh - 120px); display: flex; align-items: center;">
  <div class="container">
    <h2 class="section-title">Hoş Geldiniz</h2>
    <p class="section-subtitle">Giriş yapın veya yeni hesap oluşturun.</p>

    <div class="auth-container card">
      <div class="form-wrapper" id="formWrapper">
        
        <!-- Giriş Formu -->
        <div class="form-box form">
          <form method="post">
            <label class="full">
              <span>Kullanıcı Adı</span>
              <input type="text" name="log_username" placeholder="Kullanıcı adınız" required>
            </label>
            <label class="full">
              <span>Şifre</span>
              <input type="password" name="log_password" placeholder="••••••" required>
            </label>
            <?php if ($error): ?>
              <p style="color: #ff6b6b; font-weight: 600;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
              <p style="color: #4fd1c5; font-weight: 600;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            <button class="btn primary" type="submit" name="login" style="margin-top: 14px;">Giriş Yap</button>
            <div class="switch-links">Hesabın yok mu? <a onclick="switchForm('register')">Kayıt Ol</a></div>
          </form>
        </div>

        <!-- Kayıt Formu -->
        <div class="form-box form">
          <form method="post">
            <label class="full">
              <span>Kullanıcı Adı</span>
              <input type="text" name="reg_username" placeholder="Kullanıcı adınız" required>
            </label>
            <label class="full">
              <span>Şifre</span>
              <input type="password" name="reg_password" placeholder="••••••" required>
            </label>
            <?php if ($error): ?>
              <p style="color: #ff6b6b; font-weight: 600;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
              <p style="color: #4fd1c5; font-weight: 600;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            <button class="btn primary" type="submit" name="register" style="margin-top: 14px;">Kayıt Ol</button>
            <div class="switch-links">Zaten üye misin? <a onclick="switchForm('login')">Giriş Yap</a></div>
          </form>
        </div>

      </div>
    </div>
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
  
  function switchForm(type) {
    const wrapper = document.getElementById('formWrapper');
    if (type === 'register') {
      wrapper.style.transform = 'translateX(-50%)';
    } else {
      wrapper.style.transform = 'translateX(0%)';
    }
  }
</script>

</body>
</html>
