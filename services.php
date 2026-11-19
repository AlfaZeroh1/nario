<?php
require __DIR__ . '/includes/bootstrap.php';
$page = ['slug' => 'services', 'title' => 'What we do', 'desc' => 'White-label software for partners, R&D, custom software, SaaS products and games. ERPs, management systems, AI and data, built in Kenya.'];
include __DIR__ . '/includes/header.php';

$caps = [
    ['grid', 'ERP systems', 'Finance, inventory, procurement, HR and payroll in one place.', '#f4c542'],
    ['layers', 'Management systems', 'Schools, clinics, SACCOs, hotels, property, fleets and more.', '#22e3c9'],
    ['cart', 'POS & retail', 'Fast checkout, stock control, M-Pesa and credit sales.', '#ff4fa3'],
    ['ai', 'AI & automation', 'Assistants, document processing, forecasting and smart workflows.', '#8c6bff'],
    ['chart', 'Data & analytics', 'Dashboards, reporting and data pipelines that answer real questions.', '#4fc3ff'],
    ['mobile', 'Mobile apps', 'Android and iOS apps that stay fast on budget phones.', '#ff9f1c'],
    ['globe', 'Web platforms', 'Portals, marketplaces, booking systems and company sites.', '#c6ff4f'],
    ['plug', 'APIs & integrations', 'M-Pesa Daraja, banks, SMS, KRA eTIMS, email and third-party APIs.', '#ff6b4a'],
    ['wallet', 'Fintech', 'Wallets, lending, chama and SACCO tools, payment flows.', '#f4c542'],
    ['server', 'Cloud & DevOps', 'Hosting, backups, monitoring and multi-tenant SaaS infrastructure.', '#22e3c9'],
    ['shield', 'Security & audits', 'Code reviews, hardening and access control for existing systems.', '#ff4fa3'],
    ['game', 'Games', 'Mobile and PC games, gamified training and interactive experiences.', '#8c6bff'],
];
?>

<section class="page-hero">
  <div class="wrap page-hero-grid">
    <div>
      <div class="hero-glyph" data-glyph="NARIO LABS"></div>
      <p class="eyebrow">What we do</p>
      <h1 class="display" data-split>Anything <span class="t-pink">software</span>. <span class="t-gold">Five</span> ways to get it.</h1>
      <p class="lead reveal">Sell our engines under your brand, subscribe to our SaaS, commission a custom system, bring us a hard problem to research, or play our games. It all comes from one lab.</p>
    </div>
    <div class="hero-monkey" data-monkey></div>
  </div>
</section>

<div class="afro-band alt" aria-hidden="true"></div>

<section class="section">
  <div class="wrap">
    <div class="card service-block reveal" style="--accent:var(--gold)">
      <div>
        <span class="num">01 · Partner distribution</span>
        <h3>Engines with <span class="t-gold">your</span> name on them</h3>
        <p class="muted">For IT companies, resellers, consultants and brands that want their own software product without building an engineering team.</p>
        <a class="btn" href="partners.php" style="margin-top:14px"><span>See the partner program</span><span class="ico" data-icon="arrow"></span></a>
      </div>
      <ul class="ticks">
        <li><span><strong>Full white-label.</strong> Your logo, colours, domain, emails and receipts.</span></li>
        <li><span><strong>You own the customer.</strong> Set your own prices and keep the relationship.</span></li>
        <li><span><strong>We run the engine.</strong> Hosting, updates, security patches and second-line support.</span></li>
        <li><span><strong>Flexible deals.</strong> Licence per client, revenue share or a fixed partner plan.</span></li>
        <li><span><strong>Sales kit.</strong> Demos, training and documentation for your team.</span></li>
      </ul>
    </div>

    <div class="card service-block reveal" style="--accent:var(--teal)">
      <div>
        <span class="num">02 · Research &amp; development</span>
        <h3>Bring us the <span class="t-teal">problem</span>, not the spec</h3>
        <p class="muted">For organisations that know something is slow or expensive but aren't sure what the software answer looks like yet.</p>
        <a class="btn btn-teal" href="contact.php?interest=rnd" style="margin-top:14px"><span>Bring us a problem</span><span class="ico" data-icon="arrow"></span></a>
      </div>
      <ul class="ticks" style="--accent:var(--teal)">
        <li><span><strong>Process discovery.</strong> We map how work really flows and where it leaks.</span></li>
        <li><span><strong>Rapid prototypes.</strong> A working slice in weeks, not a slide deck.</span></li>
        <li><span><strong>AI feasibility.</strong> Honest answers on where AI helps and where it doesn't.</span></li>
        <li><span><strong>Shared IP options.</strong> Successful prototypes can grow into products we co-own.</span></li>
      </ul>
    </div>

    <div class="card service-block reveal" style="--accent:var(--pink)">
      <div>
        <span class="num">03 · Custom development</span>
        <h3>Built <span class="t-pink">for you</span>, from scratch</h3>
        <p class="muted">For businesses with workflows that no off-the-shelf product fits. You get a system designed around how you operate.</p>
        <a class="btn btn-pink" href="contact.php?interest=custom" style="margin-top:14px"><span>Start a project</span><span class="ico" data-icon="arrow"></span></a>
      </div>
      <ul class="ticks" style="--accent:var(--pink)">
        <li><span><strong>Web, mobile and desktop.</strong> One team from database to interface.</span></li>
        <li><span><strong>Fixed-scope or retainer.</strong> Clear milestones and weekly demos.</span></li>
        <li><span><strong>You own the code.</strong> Full source handover and documentation.</span></li>
        <li><span><strong>Care plans.</strong> Hosting, monitoring and improvements after launch.</span></li>
      </ul>
    </div>

    <div class="card service-block reveal" style="--accent:var(--violet)">
      <div>
        <span class="num">04 · SaaS</span>
        <h3>Sign up and <span class="t-violet">go</span></h3>
        <p class="muted">Some of our engines are available directly as subscriptions for businesses that just want to start using them.</p>
        <a class="btn btn-violet" href="products.php" style="margin-top:14px"><span>Browse products</span><span class="ico" data-icon="arrow"></span></a>
      </div>
      <ul class="ticks" style="--accent:var(--violet)">
        <li><span><strong>Monthly or yearly plans.</strong> Pay in KES via M-Pesa or card.</span></li>
        <li><span><strong>Onboarding included.</strong> Data import and team training.</span></li>
        <li><span><strong>Always current.</strong> New features ship to everyone automatically.</span></li>
      </ul>
    </div>

    <div class="card service-block reveal" style="--accent:var(--amber)">
      <div>
        <span class="num">05 · Nario Games</span>
        <h3>Games from <span class="t-amber">home</span></h3>
        <p class="muted">Our own studio, making original African games and publishing them on our accounts on Steam, the App Store and Google Play.</p>
        <a class="btn" href="games.php" style="margin-top:14px;--c1:#ffc879;--c2:var(--amber)"><span>See the games</span><span class="ico" data-icon="play"></span></a>
      </div>
      <ul class="ticks" style="--accent:var(--amber)">
        <li><span><strong>Original IP.</strong> Stories, places and humour from across Africa.</span></li>
        <li><span><strong>Mobile and PC.</strong> Built to run well on the devices people here actually own.</span></li>
        <li><span><strong>Branded games.</strong> Playable campaigns and gamified training for companies.</span></li>
      </ul>
    </div>
  </div>
</section>

<div class="marquee" aria-hidden="true">
  <div class="marquee-track">
    <?php for ($r = 0; $r < 2; $r++): foreach (['PHP', 'MySQL', 'JavaScript', 'Flutter', 'Python', 'AI', 'M-Pesa', 'Cloud'] as $w): ?>
      <span class="marquee-item"><span class="txt"><?= $w ?></span><span class="star" data-icon="spark"></span></span>
    <?php endforeach; endfor; ?>
  </div>
</div>

<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">Capabilities</p>
        <h2 class="h2" data-split>If it runs on code, we can <span class="t-gold">forge</span> it.</h2>
      </div>
      <p class="lead reveal">We're not tied to one industry. These are the kinds of things we build most often.</p>
    </div>
    <div class="caps">
      <?php foreach ($caps as $i => [$ic, $t, $d, $c]): ?>
        <div class="card cap reveal" style="--accent:<?= $c ?>;--d:<?= ($i % 4) * 80 ?>"><span class="p-ico" data-icon="<?= $ic ?>"></span><div><h4><?= e($t) ?></h4><p><?= e($d) ?></p></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">Engagement models</p>
        <h2 class="h2" data-split>Pick how we <span class="t-teal">work together</span>.</h2>
      </div>
    </div>
    <div class="models">
      <div class="card model reveal" style="--accent:var(--gold)"><h4>White-label licence</h4><p>A per-client or flat partner fee to resell an engine under your brand.</p></div>
      <div class="card model reveal" style="--accent:var(--teal);--d:100"><h4>Revenue share</h4><p>Low upfront cost. We share the subscription revenue from the clients you bring.</p></div>
      <div class="card model reveal" style="--accent:var(--pink);--d:200"><h4>Fixed project</h4><p>Defined scope, timeline and price for a custom build.</p></div>
      <div class="card model reveal" style="--accent:var(--violet);--d:300"><h4>Dedicated retainer</h4><p>A monthly block of engineering time for ongoing work.</p></div>
      <div class="card model reveal" style="--accent:var(--lime);--d:400"><h4>SaaS subscription</h4><p>Use our products directly, monthly or yearly.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <p class="eyebrow">Questions</p>
    <h2 class="h2" data-split style="margin-bottom:40px">Asked at the <span class="t-gold">origin</span>.</h2>
    <div class="faq reveal">
      <details><summary>What does "white-label" mean for my company?</summary><p>You sell one of our products as your own: your name, logo, domain and pricing. Your customers deal with you. We stay in the background, hosting, updating and supporting the engine.</p></details>
      <details><summary>Do I own the code on a custom project?</summary><p>Yes. On custom builds you get the full source code and documentation at handover. White-label and SaaS products stay ours. That is what lets us keep improving them for everyone.</p></details>
      <details><summary>Which industries do you work with?</summary><p>All of them. We've built for retail, finance, education, health and logistics, and our R&amp;D lab exists to take on new ones.</p></details>
      <details><summary>How fast can we start?</summary><p>Partners can usually demo a branded product within a week or two. Custom projects start with a short discovery phase, then we agree milestones.</p></details>
      <details><summary>Can you integrate M-Pesa, KRA eTIMS and SMS?</summary><p>Yes. Payments, tax compliance, SMS and email are standard parts of what we build for Kenyan businesses.</p></details>
      <details><summary>Where are you based?</summary><p><?= e(S('location')) ?>. We work with clients and partners anywhere, remotely.</p></details>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="cta-big mudcloth reveal">
      <h2 class="display" data-split>Got a <span class="t-pink">problem</span>? Good.</h2>
      <p class="lead" style="margin:0 auto">That's where the best products start. Tell us about it.</p>
      <div class="btn-row">
        <a class="btn btn-pink" href="contact.php"><span>Tell us about it</span><span class="ico" data-icon="arrow"></span></a>
        <a class="btn btn-wa" href="<?= e(wa_link()) ?>" target="_blank" rel="noopener"><span>WhatsApp</span><span class="ico" data-icon="whatsapp"></span></a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
