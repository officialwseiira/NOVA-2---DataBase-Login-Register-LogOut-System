<?php session_start(); ?>
<header>
  <div class="container">
    <h1 class="logo">wSeiira</h1>
    <nav>
      <ul>
        <li><a href="index.php">Ana Sayfa</a></li>
        <li><a href="pricing.php">Fiyatlandırma</a></li>
        <li><a href="index.php#contact">İletişim</a></li>
        <?php if (isset($_SESSION['user_name'])): ?>
            <li><a href="#">Hoşgeldin, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
            <li><a href="logout.php" class="btn">Çıkış Yap</a></li>
        <?php else: ?>
            <li><a href="login.php" class="btn">Giriş Yap</a></li>
            <li><a href="register.php" class="btn primary">Kayıt Ol</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
