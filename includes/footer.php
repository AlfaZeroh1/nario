<?php
$__socials = [
    'instagram' => ['Instagram', '#ff4fa3'],
    'x'         => ['X', '#f5f1e6'],
    'tiktok'    => ['TikTok', '#22e3c9'],
    'linkedin'  => ['LinkedIn', '#4fc3ff'],
    'youtube'   => ['YouTube', '#ff6b4a'],
    'facebook'  => ['Facebook', '#8c6bff'],
    'github'    => ['GitHub', '#c6ff4f'],
];
?>
</main>

<footer class="site-footer">
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <a class="brand" href="./"><span class="brand-monkey" data-monkey></span><span>NARIO <b>LABS</b></span></a>
        <p>The mother factory of software. We build the engines, our partners carry them to market, and our own products and games ship from the same forge.</p>
        <div class="socials">
          <?php foreach ($__socials as $key => [$label, $color]): if (!S($key)) continue; ?>
            <a class="social" style="--c:<?= $color ?>" href="<?= e(S($key)) ?>" target="_blank" rel="noopener" aria-label="<?= e($label) ?> <?= e(S('handle')) ?>"><span data-icon="<?= $key ?>"></span></a>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <h5>Explore</h5>
        <ul>
          <?php foreach (NAV as $slug => $label): ?>
            <li><a href="<?= $slug === 'index' ? './' : $slug . '.php' ?>"><?= e($label) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div>
        <h5>Work with us</h5>
        <ul>
          <li><a href="partners.php">Become a distributor</a></li>
          <li><a href="contact.php?interest=custom">Start a custom build</a></li>
          <li><a href="contact.php?interest=saas">Subscribe to a product</a></li>
          <li><a href="contact.php?interest=rnd">Bring us a problem</a></li>
          <li><a href="games.php">Play our games</a></li>
        </ul>
      </div>
      <div>
        <h5>Reach the origin</h5>
        <ul>
          <li><a href="mailto:<?= e(S('email')) ?>"><?= e(S('email')) ?></a></li>
          <li><a href="tel:<?= e(S('phone')) ?>"><?= e(S('phone_display')) ?></a></li>
          <li><a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener">WhatsApp us</a></li>
          <li><span class="muted"><?= e(S('location')) ?></span></li>
          <li><span class="muted"><?= e(S('handle')) ?> everywhere</span></li>
        </ul>
      </div>
    </div>

    <div class="foot-word t-gold" aria-hidden="true">Nario Labs</div>
    <div class="foot-glyph">
      <span class="gl" data-glyph="NARIO LABS"></span>
      <small>↑ "Nario Labs" in our Nario script</small>
    </div>

    <div class="foot-bottom">
      <span>© <span class="year"><?= date('Y') ?></span> Nario Labs. Built at the origin, made in Kenya.</span>
      <span>Nario: from Nariokotome, where the Turkana Boy was found.</span>
    </div>
  </div>
</footer>

<a class="wa-float" href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" aria-label="Chat with Nario Labs on WhatsApp" data-cursor="Chat">
  <span class="wa-ico" data-icon="whatsapp"></span><span>Chat with us</span>
</a>

<script>window.NARIO = <?= json_encode(site_data(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js" defer></script>
<script src="<?= asset('js/monkey.js') ?>" defer></script>
<script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
