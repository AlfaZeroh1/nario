<?php
require __DIR__ . '/includes/bootstrap.php';
$page = ['slug' => 'partners', 'title' => 'Partner program', 'desc' => 'Become a Nario Labs distribution partner: sell proven software under your own brand while we power the engine.'];
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="wrap page-hero-grid">
    <div>
      <div class="hero-glyph" data-glyph="NARIO LABS"></div>
      <p class="eyebrow">Distribution partners</p>
      <h1 class="display" data-split>Your <span class="t-teal">brand</span>. Our <span class="t-gold">engine</span>.</h1>
      <p class="lead reveal">Launch your own software products without hiring an engineering team. Pick an engine from our forge, put your name on it and sell it to your market. We keep it running.</p>
      <div class="btn-row reveal" style="margin-top:30px">
        <a class="btn" href="#apply"><span>Apply to partner</span><span class="ico" data-icon="arrow"></span></a>
        <a class="btn btn-ghost" href="products.php"><span>See the engines</span><span class="ico" data-icon="arrow"></span></a>
      </div>
    </div>
    <div class="hero-monkey" data-monkey></div>
  </div>
</section>

<div class="afro-band" aria-hidden="true"></div>

<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">How it works</p>
        <h2 class="h2" data-split>Four steps to your <span class="t-pink">own</span> product.</h2>
      </div>
    </div>
    <div class="process" style="grid-template-columns:repeat(4,1fr)">
      <div class="step reveal" style="--c:var(--gold)"><span class="dot"></span><h4>Pick an engine</h4><p>Choose from our product line: POS, ERP, school, clinic, chama and more.</p></div>
      <div class="step reveal" style="--c:var(--teal);--d:100"><span class="dot"></span><h4>Make it yours</h4><p>Name, logo, colours, domain, receipts and emails. We set it all up.</p></div>
      <div class="step reveal" style="--c:var(--pink);--d:200"><span class="dot"></span><h4>Sell &amp; support</h4><p>You own the customer, the price and the first-line relationship.</p></div>
      <div class="step reveal" style="--c:var(--violet);--d:300"><span class="dot"></span><h4>We power it</h4><p>Hosting, updates, security and second-line support, quietly in the background.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">What partners get</p>
        <h2 class="h2" data-split>Everything except the <span class="t-gold">headache</span>.</h2>
      </div>
    </div>
    <div class="values">
      <div class="card value reveal" data-tilt style="--accent:var(--gold)"><span class="p-ico" data-icon="brush"></span><h4>Full white-label</h4><p>No "powered by" badges unless you want them.</p></div>
      <div class="card value reveal" data-tilt style="--accent:var(--teal);--d:100"><span class="p-ico" data-icon="users"></span><h4>Partner portal</h4><p>Create client accounts, manage plans and track usage.</p></div>
      <div class="card value reveal" data-tilt style="--accent:var(--pink);--d:200"><span class="p-ico" data-icon="rocket"></span><h4>Sales enablement</h4><p>Demo environments, pitch material and team training.</p></div>
      <div class="card value reveal" data-tilt style="--accent:var(--violet);--d:300"><span class="p-ico" data-icon="refresh"></span><h4>Continuous updates</h4><p>Every improvement we ship reaches your clients automatically.</p></div>
      <div class="card value reveal" data-tilt style="--accent:var(--sky);--d:400"><span class="p-ico" data-icon="handshake"></span><h4>Fair economics</h4><p>Licence or revenue share, whichever fits your business.</p></div>
    </div>
  </div>
</section>

<section class="section helix-section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">Already in orbit</p>
        <h2 class="h2" data-split>Current <span class="t-gold">partners</span></h2>
      </div>
      <p class="lead reveal">Drag the spiral. Tap a partner to visit their site.</p>
    </div>
  </div>
  <div class="helix" data-helix="partner" data-cursor="Drag" data-empty="Be the first partner in our orbit.">
    <div class="helix-stage">
      <div class="helix-title"><small>Powered by Nario</small><span class="t-outline">Partners</span><div class="gl" data-glyph="NARIO LABS"></div></div>
    </div>
    <div class="helix-hint"><span data-icon="drag" style="width:16px;display:inline-block"></span> Drag to spin · Tap to visit</div>
  </div>
</section>

<section class="section" id="apply">
  <div class="wrap contact-grid">
    <div class="card form-card reveal">
      <p class="eyebrow">Apply</p>
      <h2 class="h2" style="font-size:clamp(2.2rem,4.6vw,4rem);margin-bottom:26px">Become a <span class="t-gold">partner</span></h2>
      <?php $preset = 'partner'; include __DIR__ . '/includes/contact-form.php'; ?>
    </div>
    <div class="contact-side">
      <div class="card c-line reveal" style="--accent:var(--gold)"><span class="p-ico" data-icon="target"></span><div><small>Ideal partners</small><b>IT firms, resellers, consultants, telcos, industry associations and brands with a customer base.</b></div></div>
      <div class="card c-line reveal" style="--accent:var(--teal)"><span class="p-ico" data-icon="globe"></span><div><small>Territories</small><b>Kenya first, then East Africa and beyond. Exclusive regions are possible.</b></div></div>
      <a class="card c-line reveal" href="<?= e(wa_link('Hi Nario Labs, I would like to become a distribution partner.')) ?>" target="_blank" rel="noopener" style="--accent:#25d366"><span class="p-ico" data-icon="whatsapp"></span><div><small>Faster on WhatsApp</small><b><?= e(S('phone_display')) ?></b></div></a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
