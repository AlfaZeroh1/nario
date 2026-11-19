<?php
require __DIR__ . '/includes/bootstrap.php';
$page = ['slug' => 'products', 'title' => 'Products', 'desc' => 'Software engines from Nario Labs, available as SaaS or white-label for partners to brand and distribute.'];
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="wrap page-hero-grid">
    <div>
      <div class="hero-glyph" data-glyph="NARIO LABS"></div>
      <p class="eyebrow">Products</p>
      <h1 class="display" data-split>Engines, <span class="t-gold">ready</span> to <span class="t-lime">roll</span>.</h1>
      <p class="lead reveal">Everything we are building or running. Use them directly as SaaS, or partner with us and sell them under your own brand.</p>
    </div>
    <div class="hero-monkey" data-monkey></div>
  </div>
</section>

<section class="section tight">
  <div class="wrap">
    <div class="filters" id="product-filters" aria-label="Filter products"></div>
    <div class="bento" data-bento data-filters="#product-filters" data-cta></div>
  </div>
</section>

<section class="section">
  <div class="wrap split-2">
    <div>
      <p class="eyebrow">Two ways in</p>
      <h2 class="h2" data-split>Use it, or <span class="t-gold">sell</span> it.</h2>
    </div>
    <div class="values" style="grid-template-columns:1fr 1fr">
      <div class="card value reveal" data-tilt style="--accent:var(--violet)"><span class="p-ico" data-icon="cloud"></span><h4>As SaaS</h4><p>Subscribe, onboard your team and start working. We handle hosting and updates.</p><a class="btn btn-violet btn-sm" style="margin-top:18px" href="contact.php?interest=saas"><span>Get access</span><span class="ico" data-icon="arrow"></span></a></div>
      <div class="card value reveal" data-tilt style="--accent:var(--gold);--d:100"><span class="p-ico" data-icon="engine"></span><h4>As a partner</h4><p>Put your brand on any engine and sell it to your market. We power it from behind.</p><a class="btn btn-sm" style="margin-top:18px" href="partners.php"><span>Partner program</span><span class="ico" data-icon="arrow"></span></a></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="cta-big mudcloth reveal">
      <h2 class="display" data-split>Need one we don't <span class="t-teal">have</span>?</h2>
      <p class="lead" style="margin:0 auto">Our R&amp;D lab turns recurring business problems into new engines. Yours could be next.</p>
      <div class="btn-row">
        <a class="btn btn-teal" href="contact.php?interest=rnd"><span>Pitch us a problem</span><span class="ico" data-icon="arrow"></span></a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
