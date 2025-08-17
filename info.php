<?php session_start(); ?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hakkımda — wSeiira</title>
  <meta name="description" content="Hakkımda sayfası — Nova şablonu." />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>ℹ️</text></svg>">
</head>

<body>
  <!-- Navigasyon -->
  <header class="nav">
    <a class="brand" href="./index.php">
      <svg aria-hidden="true" width="28" height="28" viewBox="0 0 24 24" class="logo"><path d="M12 2l3.09 6.26L22 9.27l-5 4.9L18.18 22 12 18.77 5.82 22 7 14.17l-5-4.9 6.91-1.01L12 2z"/></svg>
      wSeiira
    </a>

    <input id="menu-toggle" type="checkbox" class="menu-toggle" aria-label="Menüyü Aç/Kapat">
    <label for="menu-toggle" class="menu-button" aria-hidden="true"></label>

    <nav class="menu">
      <a href="./index.php" >Ana Sayfa</a>
      <a href="./info.php" class="btn ghost">Hakkımda</a>
      <a href="./contact.php" >İletişim</a>
      <?php if (isset($_SESSION["user"])): ?>
          <a href="./logout.php">Çıkış Yap</a>
      <?php else: ?>
          <a href="./giris.php">Giriş Yap</a>
      <?php endif; ?>
  </nav>
  </header>

  <!-- Hero / Başlık -->
 <section class="hero small">
  <div class="hero-content">
    <h1>Hakkımda</h1>
    <p>Kısaca kendimi ve projelerimi tanıtıyorum.</p>
  </div>
  <div class="hero-art" aria-hidden="true">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
  </div>
</section>
    

  <!-- İçerik -->
  <section class="section">
    <div class="container grid" style="align-items:center; grid-template-columns:1fr 1fr; gap:40px;">
      <div>
        <h2 class="section-title">Ben Kimim?</h2>
        <p class="section-subtitle">Merhaba, ben <strong>JstwSeiira</strong> ( 𝘙𝘢𝘮𝘢𝘻𝘢𝘯 𝘒. ) Web geliştirme, tasarım ve modern yazılım teknolojileriyle ilgileniyorum.</p>
        <p>
          Nova(Bu temaya verdiğim isim) temasını kendi projelerimde deniyor, hem frontend hem backend tarafında kendimi geliştiriyorum.  
          PHP, MySQL, modern CSS ve JavaScript ile güçlü web uygulamaları inşa etmeyi seviyorum.
        </p>
        <p>
          Ayrıca kullanıcı deneyimine önem veriyor, şık ve işlevsel arayüzler tasarlamaya çalışıyorum.
        </p>
      </div>
      <div>
        <img src="./wSeiira/wSeiira.jpeg" alt="Hakkımda görsel" style="width:100%; border-radius:var(--radius); box-shadow:var(--shadow);">
      </div>
    </div>
  </section>

  <!-- Altbilgi -->
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
