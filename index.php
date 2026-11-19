<?php
require __DIR__ . '/includes/bootstrap.php';
$page = ['slug' => 'index', 'title' => '', 'ask' => true];
include __DIR__ . '/includes/header.php';
?>

<!-- ============ INTRO: name → blinking monkey ============ -->
<section class="intro" aria-label="Nario Labs">
  <div class="intro-sticky">
    <div class="orbits" aria-hidden="true">
      <i style="--k:0;--c:#f4c542"></i><i style="--k:1;--c:#22e3c9"></i><i style="--k:2;--c:#ff4fa3"></i><i style="--k:3;--c:#8c6bff"></i>
    </div>
    <div class="intro-halo" aria-hidden="true"></div>
    <h1 class="intro-word">Nario Labs</h1>
    <div class="intro-monkey" data-monkey></div>
    <div class="intro-tag">
      <p class="h3">We build the <span class="t-gold">engines</span>. <span class="t-teal">You</span> drive the <span class="t-pink">brand</span>.</p>
      <div class="btn-row">
        <a class="btn" href="partners.php"><span>Partner with us</span><span class="ico" data-icon="arrow"></span></a>
        <a class="btn btn-teal" href="contact.php?interest=custom"><span>Start a project</span><span class="ico" data-icon="arrow"></span></a>
      </div>
    </div>
    <div class="intro-meta">
      <span>The origin point<br class="hide-sm"> of software</span>
      <span class="scroll-hint"><span class="mouse"></span>Scroll to wake him</span>
      <span class="hide-sm" style="text-align:right">Est. <?= e(S('founded')) ?><br><?= e(S('location')) ?></span>
    </div>
  </div>
</section>

<div class="afro-band" aria-hidden="true"></div>

<!-- ============ STATEMENT ============ -->
<section class="section">
  <div class="wrap statement-wrap">
    <div class="bubbles" data-bubbles="78,-4;94,30;86,74;60,96" aria-hidden="true"></div>
    <p class="eyebrow">Where it all begins <span class="gl" data-glyph="ORIGIN"></span></p>
    <p class="statement" data-scrub>
      Every lineage has a first. Nario Labs is the <span class="t-gold">origin</span> point, the mother factory where software is born and then carried into the world under many names.
    </p>
    <div class="btn-row" style="margin-top:40px">
      <a class="btn btn-ghost" href="about.php"><span>Read our origin story</span><span class="ico" data-icon="arrow"></span></a>
    </div>
  </div>
</section>

<!-- ============ WHAT WE DO ============ -->
<section class="section" id="what">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">What we do</p>
        <h2 class="h2" data-split>One forge. <span class="t-pink">Five</span> ways<br>to ship <span class="t-outline">software</span>.</h2>
      </div>
      <p class="lead reveal">We work like the factories behind the brands you know. We engineer the product once, then it reaches people through partners, through our own SaaS, through custom builds and through games.</p>
    </div>

    <div class="pillars">
      <div class="pillar reveal" style="--d:0">
        <div class="card" data-tilt style="--accent:var(--gold)">
          <span class="num">01 · Distribution</span>
          <span class="p-ico" data-icon="engine"></span>
          <h3>Engines for partners</h3>
          <p>White-label software that your company brands, sells and supports as its own. We keep the engine running underneath.</p>
          <div class="tag-row"><span class="tag">White label</span><span class="tag">Revenue share</span></div>
        </div>
      </div>
      <div class="pillar reveal" style="--d:100">
        <div class="card" data-tilt style="--accent:var(--teal)">
          <span class="num">02 · R&amp;D Lab</span>
          <span class="p-ico" data-icon="flask"></span>
          <h3>Research &amp; development</h3>
          <p>We study how businesses actually run, find the slow, costly parts and prototype a better way to do them.</p>
          <div class="tag-row"><span class="tag">Prototypes</span><span class="tag">Process</span></div>
        </div>
      </div>
      <div class="pillar reveal" style="--d:200">
        <div class="card" data-tilt style="--accent:var(--pink)">
          <span class="num">03 · Custom</span>
          <span class="p-ico" data-icon="code"></span>
          <h3>Custom software</h3>
          <p>Built for you from scratch: management systems, ERPs, portals, mobile apps, integrations and AI.</p>
          <div class="tag-row"><span class="tag">Web</span><span class="tag">Mobile</span><span class="tag">AI</span></div>
        </div>
      </div>
      <div class="pillar reveal" style="--d:0">
        <div class="card" data-tilt style="--accent:var(--violet)">
          <span class="num">04 · SaaS</span>
          <span class="p-ico" data-icon="cloud"></span>
          <h3>Our own SaaS</h3>
          <p>Some engines we run ourselves. Subscribe and start using them the same day. No partner needed, no setup project.</p>
          <div class="tag-row"><span class="tag">Subscriptions</span><span class="tag">Cloud</span></div>
        </div>
      </div>
      <div class="pillar reveal" style="--d:100">
        <div class="card" data-tilt style="--accent:var(--amber)">
          <span class="num">05 · Nario Games</span>
          <span class="p-ico" data-icon="game"></span>
          <h3>African games</h3>
          <p>Original games rooted in African stories, places and humour. We publish them ourselves on Steam and the app stores.</p>
          <div class="tag-row"><span class="tag">Steam</span><span class="tag">iOS</span><span class="tag">Android</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="marquee" aria-hidden="true">
  <div class="marquee-track">
    <?php for ($r = 0; $r < 2; $r++): foreach (['ERP', 'AI', 'Data', 'POS', 'Fintech', 'SaaS', 'Mobile', 'Games', 'Automation', 'Integrations'] as $w): ?>
      <span class="marquee-item"><span class="txt"><?= $w ?></span><span class="star" data-icon="spark"></span></span>
    <?php endforeach; endfor; ?>
  </div>
</div>

<!-- ============ MOTHER FACTORY MODEL ============ -->
<section class="section">
  <div class="wrap factory">
    <div>
      <p class="eyebrow">The mother factory model</p>
      <h2 class="h2" data-split>Built <span class="t-gold">once</span>. Sold under <span class="t-teal">many</span> names.</h2>
      <p class="lead reveal" style="margin-top:24px">The TV on your wall may carry a local brand, but it probably came from one mother factory. We do the same thing for software. Nario Labs engineers, hosts and improves the product, and our partners give it their name, their price and their customers.</p>
      <div class="factory-steps">
        <div class="fstep reveal" style="--c:var(--gold)"><b>1</b><div><h4>We engineer the engine</h4><p>Research, build, test and host the core product.</p></div></div>
        <div class="fstep reveal" style="--c:var(--teal);--d:100"><b>2</b><div><h4>You make it yours</h4><p>Your name, logo, colours, domain and pricing.</p></div></div>
        <div class="fstep reveal" style="--c:var(--pink);--d:200"><b>3</b><div><h4>You sell, we power</h4><p>You own the customer. We keep updates, uptime and support behind you.</p></div></div>
      </div>
    </div>
    <div class="orbit-map pop" data-orbitmap>
      <svg class="lines" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true"></svg>
      <div class="om-core" data-monkey></div>
      <span class="om-node" style="--c:#22e3c9">Your brand</span>
      <span class="om-node" style="--c:#ff4fa3">Partner B</span>
      <span class="om-node" style="--c:#8c6bff">Our SaaS</span>
      <span class="om-node" style="--c:#4fc3ff">Partner C</span>
      <span class="om-node" style="--c:#ff9f1c">Custom clients</span>
      <span class="om-node" style="--c:#c6ff4f">Games</span>
    </div>
  </div>
</section>

<div class="afro-band alt" aria-hidden="true"></div>

<!-- ============ PRODUCTS BENTO ============ -->
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">From the forge</p>
        <h2 class="h2" data-split>Products ready to <span class="t-lime">wear</span> your <span class="t-gold">name</span>.</h2>
      </div>
      <a class="btn btn-violet reveal" href="products.php"><span>All products</span><span class="ico" data-icon="arrow"></span></a>
    </div>
    <div class="bento" data-bento data-limit="7" data-cta></div>
  </div>
</section>

<!-- ============ PARTNERS SPIRAL ============ -->
<section class="section helix-section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">Distribution network</p>
        <h2 class="h2" data-split>Our <span class="t-gold">partners</span></h2>
      </div>
      <p class="lead reveal">Companies that carry Nario engines to market under their own names. Drag the spiral and tap a card to visit them.</p>
    </div>
  </div>
  <div class="helix" data-helix="partner" data-cursor="Drag" data-empty="Your company could be the first brand in this orbit.">
    <div class="helix-stage">
      <div class="helix-title"><small>Powered by Nario</small><span class="t-outline">Partners</span><div class="gl" data-glyph="NARIO LABS"></div></div>
    </div>
    <div class="helix-hint"><span data-icon="drag" style="width:16px;display:inline-block"></span> Drag to spin · Tap to visit</div>
  </div>
</section>

<!-- ============ CLIENTS SPIRAL ============ -->
<section class="section helix-section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">Built for</p>
        <h2 class="h2" data-split>Our <span class="t-teal">clients</span></h2>
      </div>
      <p class="lead reveal">Businesses running on software we designed and built for them, from shops and SACCOs to clinics and schools.</p>
    </div>
  </div>
  <div class="helix" data-helix="client" data-cursor="Drag" data-empty="Client stories are on their way.">
    <div class="helix-stage">
      <div class="helix-title"><small>Trusted by</small><span class="t-outline" style="-webkit-text-stroke-color:var(--teal)">Clients</span><div class="gl" data-glyph="NARIO LABS"></div></div>
    </div>
    <div class="helix-hint"><span data-icon="drag" style="width:16px;display:inline-block"></span> Drag to spin · Tap to visit</div>
  </div>
</section>

<div class="marquee rev flat" aria-hidden="true">
  <div class="marquee-track">
    <?php for ($r = 0; $r < 2; $r++): foreach (['Build once', 'Brand many', 'Research first', 'Ship African', 'Evolve forever'] as $w): ?>
      <span class="marquee-item"><span class="txt"><?= $w ?></span><span class="star" data-icon="spark"></span></span>
    <?php endforeach; endfor; ?>
  </div>
</div>

<!-- ============ GAMES ============ -->
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">Nario Games</p>
        <h2 class="h2" data-split>African stories. <span class="t-amber">Played</span> by the world.</h2>
      </div>
      <a class="btn btn-sky reveal" href="games.php"><span>Enter the arcade</span><span class="ico" data-icon="play"></span></a>
    </div>
    <div class="games" data-games data-limit="3"></div>
  </div>
</section>

<!-- ============ STATS ============ -->
<section class="section tight">
  <div class="wrap stats">
    <div class="stat reveal"><b class="t-gold" data-count="2021" data-from="1990">2021</b><span>Writing production code since</span></div>
    <div class="stat reveal" style="--d:100"><b class="t-teal" data-count="5">5</b><span>Ways we ship software</span></div>
    <div class="stat reveal" style="--d:200"><b class="t-pink">∞</b><span>Industries we can serve</span></div>
    <div class="stat reveal" style="--d:300"><b class="t-violet" data-count="1">1</b><span>Origin point. Ours.</span></div>
  </div>
</section>

<!-- ============ PROCESS ============ -->
<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">How we work</p>
        <h2 class="h2" data-split>From <span class="t-sky">problem</span> to <span class="t-gold">product</span>.</h2>
      </div>
    </div>
    <div class="process">
      <div class="step reveal" style="--c:var(--gold)"><span class="dot"></span><h4>Discover</h4><p>We sit with the people doing the work and map where time and money leak.</p></div>
      <div class="step reveal" style="--c:var(--teal);--d:100"><span class="dot"></span><h4>Prototype</h4><p>The R&amp;D lab builds a working slice fast, so you can judge something real.</p></div>
      <div class="step reveal" style="--c:var(--pink);--d:200"><span class="dot"></span><h4>Build</h4><p>Production engineering: secure, tested, fast on low-end devices and patchy networks.</p></div>
      <div class="step reveal" style="--c:var(--violet);--d:300"><span class="dot"></span><h4>Brand &amp; ship</h4><p>Under your name, as our SaaS, or as a custom system. Deployed and documented.</p></div>
      <div class="step reveal" style="--c:var(--lime);--d:400"><span class="dot"></span><h4>Evolve</h4><p>Every improvement to the engine reaches every brand built on it.</p></div>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="section">
  <div class="wrap">
    <div class="cta-big mudcloth reveal">
      <div class="cta-monkey" data-monkey></div>
      <p class="eyebrow" style="justify-content:center">Ready when you are</p>
      <h2 class="display" data-split>Start at the <span class="t-gold">origin</span>.</h2>
      <p class="lead" style="margin:0 auto">Want to sell software under your brand, get a system built, or fix a process that drains your team? Tell us. We reply within one working day.</p>
      <div class="btn-row">
        <a class="btn" href="partners.php"><span>Become a partner</span><span class="ico" data-icon="arrow"></span></a>
        <a class="btn btn-pink" href="contact.php"><span>Start a project</span><span class="ico" data-icon="arrow"></span></a>
        <a class="btn btn-wa" href="<?= e(wa_link()) ?>" target="_blank" rel="noopener"><span>WhatsApp us</span><span class="ico" data-icon="whatsapp"></span></a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
