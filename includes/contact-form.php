<?php
/** Shared contact form. Set $preset (interest value) before including to pre-select an option. */
$preset = $preset ?? '';
$__interests = [
    'partner' => ['Partnership', '#f4c542'],
    'custom'  => ['Custom build', '#ff4fa3'],
    'saas'    => ['SaaS product', '#8c6bff'],
    'rnd'     => ['R&D / a problem', '#22e3c9'],
    'games'   => ['Games', '#ff9f1c'],
    'other'   => ['Something else', '#4fc3ff'],
];
?>
<form class="contact-form" data-contact action="api/contact.php" method="post" novalidate>
  <?= csrf_field() ?>
  <input class="hp" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
  <div class="fields">
    <div class="field full">
      <label>I'm interested in</label>
      <div class="pick">
        <?php foreach ($__interests as $val => [$label, $color]): ?>
          <input type="radio" name="interest" id="i-<?= $val ?>" value="<?= $val ?>"<?= $preset === $val ? ' checked' : '' ?>>
          <label for="i-<?= $val ?>" style="--c:<?= $color ?>"><?= e($label) ?></label>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="field"><label for="f-name">Your name</label><input id="f-name" name="name" required autocomplete="name"></div>
    <div class="field"><label for="f-email">Email</label><input id="f-email" type="email" name="email" required autocomplete="email"></div>
    <div class="field"><label for="f-phone">Phone / WhatsApp</label><input id="f-phone" name="phone" autocomplete="tel"></div>
    <div class="field"><label for="f-company">Company</label><input id="f-company" name="company" autocomplete="organization"></div>
    <div class="field full">
      <label for="f-budget">Budget (optional)</label>
      <select id="f-budget" name="budget">
        <option value="">Not sure yet</option>
        <option>Under KES 100k</option>
        <option>KES 100k – 500k</option>
        <option>KES 500k – 2M</option>
        <option>KES 2M+</option>
        <option>Revenue share / partnership</option>
      </select>
    </div>
    <div class="field full"><label for="f-message">Tell us about it</label><textarea id="f-message" name="message" required placeholder="What are you building, selling or trying to fix?"></textarea></div>
  </div>
  <div class="btn-row" style="margin-top:20px">
    <button class="btn" type="submit"><span>Send to the origin</span><span class="ico" data-icon="arrow"></span></button>
    <span class="muted" style="font-size:.88rem">We reply within one working day.</span>
  </div>
  <div class="form-status" role="status" aria-live="polite"></div>
</form>
