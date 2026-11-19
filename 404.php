<?php
require __DIR__ . '/includes/bootstrap.php';
http_response_code(404);
$page = ['slug' => '404', 'title' => 'Lost in space'];
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero" style="min-height:100vh;display:grid;place-items:center;text-align:center">
  <div class="wrap">
    <div class="hero-monkey" data-monkey style="margin:0 auto 30px;justify-self:center"></div>
    <h1 class="display"><span class="t-gold">404</span> · Lost in <span class="t-teal">space</span></h1>
    <p class="lead" style="margin:20px auto 30px">Even the Turkana Boy took 1.5 million years to be found. This page may take longer.</p>
    <a class="btn" href="./"><span>Back to the origin</span><span class="ico" data-icon="arrow"></span></a>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
