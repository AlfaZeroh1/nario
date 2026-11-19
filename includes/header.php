<?php
/** @var array $page  ['slug','title','desc','ask'] set by each page before including this file. */
$__title = !empty($page['title']) ? $page['title'] . ' · Nario Labs' : 'Nario Labs · ' . S('tagline');
$__desc  = $page['desc'] ?? S('meta_description');
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($__title) ?></title>
<meta name="description" content="<?= e($__desc) ?>">
<meta name="theme-color" content="#05050a">
<meta property="og:title" content="<?= e($__title) ?>">
<meta property="og:description" content="<?= e($__desc) ?>">
<meta property="og:image" content="assets/img/logo-full.jpg">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="assets/img/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="assets/img/logo-full.jpg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@500;700;800;900&family=JetBrains+Mono:wght@400;500;600&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body class="is-loading page-<?= e($page['slug']) ?>" data-page="<?= e($page['slug']) ?>">
<a class="skip" href="#main">Skip to content</a>

<!-- Space backdrop: stars, aura, glyph spotlight, cursor -->
<canvas id="stars" aria-hidden="true"></canvas>
<div class="aura" aria-hidden="true"><i></i><i></i><i></i></div>
<div class="glyphs dim" aria-hidden="true"></div>
<div class="glyphs lit" aria-hidden="true"></div>
<div class="cursor-glow" aria-hidden="true"></div>
<div class="cursor-dot" aria-hidden="true"></div>
<div class="cursor-ring" aria-hidden="true"><span></span></div>

<!-- Preloader -->
<div class="preloader" data-ask="<?= !empty($page['ask']) ? '1' : '0' ?>" role="status" aria-label="Loading">
  <div class="pl-inner">
    <div class="pl-monkey" data-monkey></div>
    <div class="pl-count t-gold">0</div>
    <div class="pl-bar"><i></i></div>
    <div class="pl-glyph" data-glyph="NARIO LABS"></div>
    <div class="pl-choice">
      <button class="btn" type="button" data-enter="sound"><span>Enter with sound</span><span class="ico" data-icon="arrow"></span></button>
      <button class="btn btn-ghost" type="button" data-enter="silent"><span>Enter in silence</span><span class="ico" data-icon="arrow"></span></button>
    </div>
    <div class="pl-note">Best with headphones · You can switch sound anytime</div>
  </div>
</div>

<header class="site-header">
  <a class="brand" href="./" aria-label="Nario Labs home">
    <span class="brand-monkey" data-monkey></span>
    <span>NARIO <b>LABS</b></span>
  </a>
  <nav class="nav" aria-label="Main">
    <?php foreach (NAV as $slug => $label): if ($slug === 'index') continue; ?>
      <a class="<?= nav_active($slug) ?>" href="<?= $slug ?>.php"><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
  <div class="header-actions">
    <button class="sound-toggle" type="button" aria-pressed="false" aria-label="Toggle sound"><span class="eq"><i></i><i></i><i></i><i></i></span><span class="lbl">Sound off</span></button>
    <a class="btn btn-pink btn-sm" href="contact.php"><span>Let's talk</span><span class="ico" data-icon="arrow"></span></a>
    <button class="burger" type="button" aria-label="Menu" aria-expanded="false"><i></i><i></i></button>
  </div>
</header>

<div class="mobile-menu" aria-label="Mobile menu">
  <?php foreach (NAV as $slug => $label): ?>
    <a class="big<?= nav_active($slug) ?>" href="<?= $slug === 'index' ? './' : $slug . '.php' ?>"><?= e($label) ?></a>
  <?php endforeach; ?>
  <div class="mm-foot">
    <a class="btn btn-wa" href="<?= e(wa_link()) ?>" target="_blank" rel="noopener"><span>WhatsApp</span><span class="ico" data-icon="whatsapp"></span></a>
    <a class="btn btn-ghost" href="mailto:<?= e(S('email')) ?>"><span>Email us</span><span class="ico" data-icon="mail"></span></a>
  </div>
</div>

<main id="main">
