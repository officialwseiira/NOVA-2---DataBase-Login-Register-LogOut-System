<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>İletişim — wSeiira</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
    }
    @media(max-width:768px) {
      .contact-grid {
        grid-template-columns: 1fr;
      }
    }
    .contact-info {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      box-shadow: var(--shadow);
    }
    .contact-info h3 {
      margin-bottom: 12px;
    }
    .contact-info p {
      margin: 6px 0;
    }
    .contact-form {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      box-shadow: var(--shadow);
    }
    .form-group {
      position: relative;
      margin-bottom: 20px;
    }
    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 14px 12px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      background: var(--card);
      font-size: 15px;
      outline: none;
      transition: all 0.2s ease;
      resize: none;
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
    .form-group input:not(:placeholder-shown) + label,
    .form-group textarea:focus + label,
    .form-group textarea:not(:placeholder-shown) + label {
      top: 4px;
      font-size: 12px;
      color: var(--brand);
    }
    .form-group input:focus,
    .form-group textarea:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(79, 209, 197, 0.25);
    }
  </style>
</head>
<body>

<?php session_start(); ?>
<header class="nav">
  <a class="brand" href="./index.php">
    <svg aria-hidden="true" width="28" height="28" viewBox="0 0 24 24" class="logo">
      <path d="M12 2l3.09 6.26L22 9.27l-5 4.9L18.18 22 12 18.77 
               5.82 22 7 14.17l-5-4.9 6.91-1.01L12 2z"/>
    </svg>
    wSeiira
  </a>


  <!-- CSS-only açılır menü -->
  <input id="menu-toggle" type="checkbox" class="menu-toggle" aria-label="Menüyü Aç/Kapat">
  <label for="menu-toggle" class="menu-button" aria-hidden="true"></label>

  <nav class="menu">
      <a href="./index.php" >Ana Sayfa</a>
      <a href="./info.php">Hakkımda</a>
      <a href="./contact.php" class="btn ghost">İletişim</a>
      <?php if (isset($_SESSION["user"])): ?>
          <a href="./logout.php">Çıkış Yap</a>
      <?php else: ?>
          <a href="./giris.php">Giriş Yap</a>
      <?php endif; ?>
  </nav>
</header>


<section id="contact" class="section">

 <div class="container contact-grid">

    <!-- İletişim Bilgileri -->
    <div class="contact-info">
      <h3>Bize Ulaşın</h3>
      <p><strong>Adres:</strong> Kocaeli, Türkiye</p>
      <p><strong>Telefon:</strong> +90 555 000 00 00</p>
      <p><strong>E-posta:</strong> officialwSeiira@gmail.com</p>
      <p class="muted">Sosyal Medya: <a href="https://instagram.com/jstwSeiira">@jstwSeiira</a></p>
    </div>

    <div class="container">
      <h2 class="section-title">Bana Mesaj Gönder</h2>
      <form class="card form" action="mail.php" method="post">
        <div class="grid form-grid">
          <label>
            <span>Ad Soyad</span>
            <input type="text" name="name" placeholder="Adınız Soyadınız" required>
          </label>
          <label>
            <span>E-posta</span>
            <input type="email" name="email" placeholder="ornek@mail.com" required>
          </label>
          <label class="full">
            <span>Mesaj</span>
            <textarea name="message" rows="5" placeholder="Kısaca yazın..." required></textarea>
          </label>
        </div>
        <button class="btn primary" type="submit">Gönder</button>
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
