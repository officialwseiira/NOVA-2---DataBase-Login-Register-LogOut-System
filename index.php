<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>wSeiira - Ramazan Kansu</title>
  <meta name="description" content="Şık, hızlı ve mobil uyumlu tek sayfa web sitesi şablonu." />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>✨</text></svg>">
  <meta property="og:title" content="wSeiira — Şık & Modern" />
  <meta property="og:description" content="Modern tek sayfa şablon." />
  <meta property="og:type" content="website" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

 
</head>

<body>
  <!-- Üst Şerit -->
  <div class="topbar">
    <a href="https://instagram.com/jstwseiira" target="_blank" class="insta-link">
      <i class="fab fa-instagram"></i> JstwSeiira
    </a>
  </div>  

  <!-- Navigasyon -->
<header class="nav">
  <a class="brand" href="./index.php">
    <svg aria-hidden="true" width="28" height="28" viewBox="0 0 24 24" class="logo">
      <path d="M12 2l3.09 6.26L22 9.27l-5 4.9L18.18 22 12 18.77 
               5.82 22 7 14.17l-5-4.9 6.91-1.01L12 2z"/>
    </svg>
    wSeiira
  </a>

  <!-- Ortada kullanıcı adı -->
  

  <!-- CSS-only açılır menü -->
  <input id="menu-toggle" type="checkbox" class="menu-toggle" aria-label="Menüyü Aç/Kapat">
  <label for="menu-toggle" class="menu-button" aria-hidden="true"></label>

  <nav class="menu">
      <a href="./index.php" class="btn ghost">Ana Sayfa</a>
      <a href="./info.php">Hakkımda</a>
      <a href="./contact.php" >İletişim</a>
      <?php if (isset($_SESSION["user"])): ?>
          <a href="./logout.php">Çıkış Yap</a>
      <?php else: ?>
          <a href="./giris.php">Giriş Yap</a>
      <?php endif; ?>
  </nav>
</header>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-content">
      <h1>Şık. Hızlı. Esnek.</h1>
      <p>wSeiira, modern markalar için minimal ve performanslı bir şablonudur. Tamamen duyarlı, erişilebilir ve kolayca özelleştirilebilir.</p>
      <div class="hero-actions">
        <a href="#pricing" class="btn primary">Hemen Başla</a>
        <a href="#features" class="btn ghost">Daha Fazla</a>
      </div>
      <ul class="hero-badges">
        <li>⚡ 100% Responsive</li>
        <li>Hızlı ve dinamik</li>
        <li>Şık ve yeni nesil</li>
      </ul>
    </div>
    <div class="hero-art" aria-hidden="true">
      <div class="orb orb-1"></div>
      <div class="orb orb-2"></div>
      <div class="orb orb-3"></div>
    </div>
  </section>

  <!-- Özellikler -->
  <section id="features" class="section">
    <div class="container">

        <h2 class="section-title">Merhaba</h2>

     
      <p class="section-subtitle">Sadelik ve estetiği, kullanışlı bileşenlerle birleştirdik.</p>

      <div class="grid features">
        <article class="card">
          <div class="icon">🎨</div>
          <h3>Zarif Tasarım</h3>
          <p>Tipografi ve boşluk odaklı, modern bir görsel dil.</p>
        </article>
        <article class="card">
          <div class="icon">⚙️</div>
          <h3>Kolay Özelleştirme</h3>
          <p>Renkler ve ölçüler CSS değişkenleriyle tek noktadan yönetilir.</p>
        </article>
        <article class="card">
          <div class="icon">📱</div>
          <h3>Tam Duyarlı</h3>
          <p>Mobil, tablet ve masaüstünde kusursuz deneyim.</p>
        </article>
        <article class="card">
          <div class="icon">🚀</div>
          <h3>Hızlı Yükleme</h3>
          <p>Az bağımlılık, yüksek performans, temiz kod.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- Galeri 
  <section id="gallery" class="section alt">
    <div class="container">
      <h2 class="section-title">Galeri</h2>
      <p class="section-subtitle">Projelerinizden ekran görüntüleri ya da ürün görselleri.</p>

      <div class="grid gallery">
        <figure class="shot"><img src="https://picsum.photos/640/420?1" alt="Örnek görsel 1"><figcaption>Örnek görsel 1</figcaption></figure>
        <figure class="shot"><img src="https://picsum.photos/640/420?2" alt="Örnek görsel 2"><figcaption>Örnek görsel 2</figcaption></figure>
        <figure class="shot"><img src="https://picsum.photos/640/420?3" alt="Örnek görsel 3"><figcaption>Örnek görsel 3</figcaption></figure>
        <figure class="shot"><img src="https://picsum.photos/640/420?4" alt="Örnek görsel 4"><figcaption>Örnek görsel 4</figcaption></figure>
        <figure class="shot"><img src="https://picsum.photos/640/420?5" alt="Örnek görsel 5"><figcaption>Örnek görsel 5</figcaption></figure>
        <figure class="shot"><img src="https://picsum.photos/640/420?6" alt="Örnek görsel 6"><figcaption>Örnek görsel 6</figcaption></figure>
      </div>
    </div>
  </section>

 Yorumlar   
  <section id="testimonials" class="section">
    <div class="container">
      <h2 class="section-title">Kullanıcı Yorumları</h2>
      <div class="grid testimonials">
        <blockquote class="card quote">
          <p>“wSeiira ile 1 günde kurumsal iniş sayfamızı yayınladık. Harika!”</p>
          <footer>— Aylin K., Ürün Yöneticisi</footer>
        </blockquote>
        <blockquote class="card quote">
          <p>“Temiz kod, güzel tipografi ve hızlı performans. Daha ne olsun.”</p>
          <footer>— Emre T., Geliştirici</footer>
        </blockquote>
        <blockquote class="card quote">
          <p>“Müşteri dönüşlerimiz bariz arttı. Tavsiye ederim.”</p>
          <footer>— Sude A., Pazarlama</footer>
        </blockquote>
      </div>
    </div>
  </section>

  <!-- Fiyatlar
  <section id="pricing" class="section alt">
    <div class="container">
      <h2 class="section-title">Basit Fiyatlandırma</h2>
      <p class="section-subtitle">İhtiyacınıza uygun esnek paketler.</p>

      <div class="grid pricing">
        <div class="card plan">
          <h3>Başlangıç</h3>
          <div class="price">₺0</div>
          <ul class="list">
            <li>Tek sayfa</li>
            <li>Temel destek</li>
            <li>Standart hız</li>
          </ul>
          <a class="btn primary" href="#contact">Seç</a>
        </div>

        <div class="card plan featured">
          <div class="badge">En Popüler</div>
          <h3>Pro</h3>
          <div class="price">₺990</div>
          <ul class="list">
            <li>Çoklu sayfa</li>
            <li>Öncelikli destek</li>
            <li>Gelişmiş performans</li>
          </ul>
          <a class="btn primary" href="#contact">Seç</a>
        </div>

        <div class="card plan">
          <h3>Kurumsal</h3>
          <div class="price">İletişim</div>
          <ul class="list">
            <li>Özel tasarım</li>
            <li>Bakım & SLA</li>
            <li>SEO danışmanlığı</li>
          </ul>
          <a class="btn ghost" href="#contact">Teklif Al</a>
        </div>
      </div>
    </div>
  </section>

İletişim -->
  <section id="contact" class="section">
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
  
  <!-- Küçük yardımcı: yıl doldurma -->
  <script>
    document.getElementById('yil').textContent = new Date().getFullYear();
  </script>

  <!-- Orb mouse hareket efekti -->
  <script>
    const orbs = document.querySelectorAll('.orb');

    document.addEventListener('mousemove', (e) => {
      let x = (e.clientX / window.innerWidth - 0.5) * 40; 
      let y = (e.clientY / window.innerHeight - 0.5) * 40; 

      orbs.forEach((orb, i) => {
        let factor = (i + 1) * 8; 
        orb.style.transform = `translate(${x / factor}px, ${y / factor}px)`;
      });
    });
  </script>
</body>
</html>
