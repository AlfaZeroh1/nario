<?php
require __DIR__ . '/includes/bootstrap.php';
$page = ['slug' => 'contact', 'title' => 'Contact', 'desc' => 'Talk to Nario Labs about partnerships, custom software, SaaS, R&D or games. Email, call or WhatsApp.'];
include __DIR__ . '/includes/header.php';
$preset = preg_replace('/[^a-z]/', '', (string)($_GET['interest'] ?? ''));
?>

<section class="page-hero" style="padding-bottom:30px">
  <div class="wrap page-hero-grid">
    <div>
      <div class="hero-glyph" data-glyph="NARIO LABS"></div>
      <p class="eyebrow">Contact</p>
      <h1 class="display" data-split>Say <span class="t-gold">jambo</span> to the <span class="t-pink">origin</span>.</h1>
      <p class="lead reveal">Partnerships, projects, products or a problem that's keeping you up at night. Send a message, call, or find us on WhatsApp.</p>
    </div>
    <div class="hero-monkey" data-monkey></div>
  </div>
</section>

<section class="section tight">
  <div class="wrap contact-grid">
    <div class="card form-card reveal">
      <?php include __DIR__ . '/includes/contact-form.php'; ?>
    </div>
    <div class="contact-side">
      <a class="card c-line reveal" href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" style="--accent:#25d366" data-cursor="Chat"><span class="p-ico" data-icon="whatsapp"></span><div><small>WhatsApp · fastest</small><b><?= e(S('phone_display')) ?></b></div></a>
      <a class="card c-line reveal" href="mailto:<?= e(S('email')) ?>" style="--accent:var(--gold)"><span class="p-ico" data-icon="mail"></span><div><small>Email</small><b><?= e(S('email')) ?></b></div></a>
      <a class="card c-line reveal" href="tel:<?= e(S('phone')) ?>" style="--accent:var(--teal)"><span class="p-ico" data-icon="phone"></span><div><small>Call</small><b><?= e(S('phone_display')) ?></b></div></a>
      <div class="card c-line reveal" style="--accent:var(--violet)"><span class="p-ico" data-icon="pin"></span><div><small>Base</small><b><?= e(S('location')) ?></b></div></div>
      <div class="card reveal" style="padding:22px">
        <small class="muted" style="font:.7rem var(--f-mono);letter-spacing:.12em;text-transform:uppercase">Find us everywhere as <?= e(S('handle')) ?></small>
        <div class="socials" style="margin-top:14px">
          <?php foreach (['instagram' => '#ff4fa3', 'x' => '#f5f1e6', 'tiktok' => '#22e3c9', 'linkedin' => '#4fc3ff', 'youtube' => '#ff6b4a', 'facebook' => '#8c6bff', 'github' => '#c6ff4f'] as $k => $c): if (!S($k)) continue; ?>
            <a class="social" style="--c:<?= $c ?>" href="<?= e(S($k)) ?>" target="_blank" rel="noopener" aria-label="<?= e(ucfirst($k)) ?>"><span data-icon="<?= $k ?>"></span></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
