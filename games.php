<?php
require __DIR__ . '/includes/bootstrap.php';
$page = ['slug' => 'games', 'title' => 'Nario Games', 'desc' => 'Nario Games makes original African games for PC and mobile, published on Steam, the App Store and Google Play.'];
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="wrap page-hero-grid">
    <div>
      <div class="hero-glyph" data-glyph="NARIO GAMES"></div>
      <p class="eyebrow">Nario Games</p>
      <h1 class="display" data-split>Press <span class="t-amber">start</span> on <span class="t-gold">Africa</span>.</h1>
      <p class="lead reveal">Our games studio builds original titles from African stories, landscapes, myths and the chaos of everyday city life, and publishes them ourselves on Steam, the App Store and Google Play.</p>
    </div>
    <div class="hero-monkey" data-monkey></div>
  </div>
</section>

<div class="afro-band alt" aria-hidden="true"></div>

<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">In the forge</p>
        <h2 class="h2" data-split>The <span class="t-pink">line-up</span></h2>
      </div>
      <p class="lead reveal">Titles in development, prototyping and early concept. Follow <?= e(S('handle')) ?> for devlogs, playtests and launch dates.</p>
    </div>
    <div class="games" data-games></div>
  </div>
</section>

<div class="marquee" aria-hidden="true">
  <div class="marquee-track">
    <?php for ($r = 0; $r < 2; $r++): foreach (['Steam', 'App Store', 'Google Play', 'Made in Kenya', 'African myths', 'Matatu culture'] as $w): ?>
      <span class="marquee-item"><span class="txt"><?= $w ?></span><span class="star" data-icon="spark"></span></span>
    <?php endforeach; endfor; ?>
  </div>
</div>

<section class="section">
  <div class="wrap split-2">
    <div>
      <p class="eyebrow">Why African games</p>
      <h2 class="h2" data-split>Our stories deserve <span class="t-gold">great</span> games.</h2>
    </div>
    <div class="prose">
      <p class="reveal">Africa has one of the world's youngest and fastest-growing player bases, but very few games that look, sound or feel like home. We want to change that, with original worlds, local voices and music, and gameplay that runs smoothly on the phones people here actually carry.</p>
      <p class="reveal">We also build <strong>branded games and gamified training</strong> for companies that want to reach people through play.</p>
      <div class="btn-row reveal" style="margin-top:26px">
        <a class="btn btn-pink" href="contact.php?interest=games"><span>Commission a game</span><span class="ico" data-icon="arrow"></span></a>
        <a class="btn btn-ghost" href="<?= e(S('youtube')) ?>" target="_blank" rel="noopener"><span>Watch devlogs</span><span class="ico" data-icon="youtube"></span></a>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="cta-big mudcloth reveal">
      <div class="cta-monkey" data-monkey></div>
      <h2 class="display" data-split>Join the <span class="t-amber">playtest</span>.</h2>
      <p class="lead" style="margin:0 auto">Follow <?= e(S('handle')) ?> to get early builds, beta keys and behind-the-scenes devlogs.</p>
      <div class="btn-row">
        <a class="btn btn-pink" href="<?= e(S('instagram')) ?>" target="_blank" rel="noopener"><span>Instagram</span><span class="ico" data-icon="instagram"></span></a>
        <a class="btn btn-teal" href="<?= e(S('tiktok')) ?>" target="_blank" rel="noopener"><span>TikTok</span><span class="ico" data-icon="tiktok"></span></a>
        <a class="btn btn-ghost" href="<?= e(S('x')) ?>" target="_blank" rel="noopener"><span>X</span><span class="ico" data-icon="x"></span></a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
