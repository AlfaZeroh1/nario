/* ==================================================================
 * Nario Labs — the animated monkey + the Nario glyph script.
 * Shared by the public site and the admin.
 *
 *  <div data-monkey></div>          → animated monkey (blinks, eyes follow the pointer)
 *  <span data-glyph="NARIO LABS">   → text written in the Nario (Wakanda-inspired) script
 * ================================================================== */
(function () {
  'use strict';

  /* ---------------- Monkey ----------------
   * Geometry is a vector rebuild of the Nario Labs logo, drawn in a 500 × 512 box.
   * Left-side plates are drawn once and mirrored. Gold plates are separated by
   * thick space-black strokes, like the logo.                                  */
  let uid = 0;
  const LEFT = [
    '8,130 48,130 48,272 26,258 3,182',          // ear
    '62,120 100,142 100,338 62,326',              // side bar
    '165,14 165,110 108,158 70,104',              // upper temple plate
    '108,258 158,298 122,350 122,412 108,396',    // lower cheek
  ];
  const EYE_L = '128,190 200,193 190,216 148,214';
  const EYE_R = '372,190 300,193 310,216 352,214';

  function monkeySVG() {
    const id = 'mk' + (++uid);
    return `
<svg class="monkey" viewBox="-12 -12 524 536" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Nario Labs monkey">
  <defs>
    <linearGradient id="${id}g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#d9a52c"/><stop offset=".45" stop-color="#ffde6e"/>
      <stop offset=".7" stop-color="#f6c94a"/><stop offset="1" stop-color="#c8901a"/>
    </linearGradient>
    <linearGradient id="${id}s" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset=".5" stop-color="#fff" stop-opacity=".55"/><stop offset="1" stop-color="#fff" stop-opacity="0"/>
    </linearGradient>
    <clipPath id="${id}cl"><polygon points="${EYE_L}"/></clipPath>
    <clipPath id="${id}cr"><polygon points="${EYE_R}"/></clipPath>
    <clipPath id="${id}all">${LEFT.map(p => `<polygon points="${p}"/><polygon points="${p}" transform="translate(500 0) scale(-1 1)"/>`).join('')}
      <polygon points="180,0 320,0 320,112 250,130 180,112"/>
      <polygon points="110,172 180,124 250,144 320,124 390,172 390,250 338,292 300,262 250,252 200,262 162,292 110,250"/>
      <path d="M200 270 L250 258 L300 270 L352 310 L372 342 L372 420 L352 446 L148 446 L128 420 L128 342 L148 310 Z"/>
      <polygon points="172,456 328,456 308,504 250,512 192,504"/></clipPath>
  </defs>
  <g class="mk-plates" fill="url(#${id}g)" stroke="#05050a" stroke-width="11" stroke-linejoin="round">
    <g id="${id}half">${LEFT.map(p => `<polygon points="${p}"/>`).join('')}</g>
    <use href="#${id}half" transform="translate(500 0) scale(-1 1)"/>
    <polygon points="180,0 320,0 320,112 250,130 180,112"/>
    <polygon points="110,172 180,124 250,144 320,124 390,172 390,250 338,292 300,262 250,252 200,262 162,292 110,250"/>
    <path d="M200 270 L250 258 L300 270 L352 310 L372 342 L372 420 L352 446 L148 446 L128 420 L128 342 L148 310 Z"/>
    <polygon points="172,456 328,456 308,504 250,512 192,504"/>
  </g>
  <g class="mk-lines" fill="none" stroke="#05050a" stroke-width="9" stroke-linecap="round" stroke-linejoin="round">
    <path d="M200 193 L214 240 L250 250 L286 240 L300 193"/>
    <path d="M206 304 L206 324 L226 340"/><path d="M294 304 L294 324 L274 340"/>
  </g>
  <g class="mk-eye mk-eye-l">
    <polygon class="mk-sclera" points="${EYE_L}" fill="#fff"/>
    <g clip-path="url(#${id}cl)"><g class="mk-pupil"><circle cx="166" cy="204" r="9" fill="#05050a"/><circle cx="169" cy="200" r="2.6" fill="#fff"/></g></g>
    <polygon points="${EYE_L}" fill="none" stroke="#05050a" stroke-width="7" stroke-linejoin="round"/>
  </g>
  <g class="mk-eye mk-eye-r">
    <polygon class="mk-sclera" points="${EYE_R}" fill="#fff"/>
    <g clip-path="url(#${id}cr)"><g class="mk-pupil"><circle cx="334" cy="204" r="9" fill="#05050a"/><circle cx="337" cy="200" r="2.6" fill="#fff"/></g></g>
    <polygon points="${EYE_R}" fill="none" stroke="#05050a" stroke-width="7" stroke-linejoin="round"/>
  </g>
  <g clip-path="url(#${id}all)"><rect class="mk-shine" x="-260" y="-20" width="160" height="560" fill="url(#${id}s)" transform="skewX(-18)"/></g>
</svg>`;
  }

  const monkeys = [];
  let px = window.innerWidth / 2, py = window.innerHeight / 3, dirty = true;
  // Only monkeys on screen are tracked; the rest cost nothing.
  const vis = 'IntersectionObserver' in window ? new IntersectionObserver(entries => {
    entries.forEach(en => { const m = monkeys.find(k => k.el === en.target); if (m) { m.visible = en.isIntersecting; dirty = true; } });
  }) : null;

  function mount(root) {
    (root || document).querySelectorAll('[data-monkey]:not([data-mounted])').forEach(el => {
      el.dataset.mounted = '1';
      el.innerHTML = monkeySVG();
      const svg = el.firstElementChild;
      const m = { el, svg, pupils: svg.querySelectorAll('.mk-pupil'), cur: { x: 0, y: 0 }, visible: !vis };
      monkeys.push(m);
      if (vis) vis.observe(el);
      scheduleBlink(m);
      if (el.closest('.intro-monkey, .hero-monkey, .pl-monkey')) scheduleShine(svg);
    });
  }
  // The gold sheen runs only on the big monkeys, now and then, instead of looping forever.
  function scheduleShine(svg) {
    setTimeout(() => {
      if (!document.hidden) { svg.classList.add('shine'); setTimeout(() => svg.classList.remove('shine'), 1900); }
      scheduleShine(svg);
    }, 5000 + Math.random() * 4000);
  }

  function blink(svg, twice) {
    svg.classList.add('blink');
    setTimeout(() => {
      svg.classList.remove('blink');
      if (twice) setTimeout(() => blink(svg, false), 160);
    }, 130);
  }
  function scheduleBlink(m) {
    setTimeout(() => {
      if (!document.hidden && m.visible) blink(m.svg, Math.random() < 0.25);
      scheduleBlink(m);
    }, 2200 + Math.random() * 4200);
  }

  window.addEventListener('pointermove', e => { px = e.clientX; py = e.clientY; dirty = true; }, { passive: true });
  window.addEventListener('touchmove', e => { if (e.touches[0]) { px = e.touches[0].clientX; py = e.touches[0].clientY; dirty = true; } }, { passive: true });
  window.addEventListener('scroll', () => { dirty = true; }, { passive: true });
  window.addEventListener('resize', () => { dirty = true; });

  // Runs first in each frame (this script loads before main.js), so its layout reads never collide with style writes.
  function track() {
    for (const m of monkeys) {
      if (!m.visible) continue;
      if (dirty || !m.target) {
        const r = m.svg.getBoundingClientRect();
        if (!r.width) continue;
        const cx = r.left + r.width / 2, cy = r.top + r.height * 0.4;
        const dx = px - cx, dy = py - cy, d = Math.hypot(dx, dy) || 1;
        const k = Math.min(d / 260, 1);
        m.target = { x: (dx / d) * 15 * k, y: (dy / d) * 5 * k };
      }
      const ex = m.target.x - m.cur.x, ey = m.target.y - m.cur.y;
      if (Math.abs(ex) < 0.03 && Math.abs(ey) < 0.03) continue; // eyes have arrived: no repaint
      m.cur.x += ex * 0.18; m.cur.y += ey * 0.18;
      const tr = `translate(${m.cur.x.toFixed(2)} ${m.cur.y.toFixed(2)})`;
      m.pupils.forEach(p => p.setAttribute('transform', tr));
    }
    dirty = false;
    requestAnimationFrame(track);
  }
  requestAnimationFrame(track);

  /* ---------------- Nario glyph script ----------------
   * An original, Wakanda-inspired alphabet (angular strokes, dots, rings).
   * Each glyph is a 20 × 28 path. N A R I O L B S are hand-drawn;
   * the rest are composed deterministically from a stroke kit.          */
  const G = {
    N: 'M4 3v22M4 8l11 6-11 6M16 3v5M16 24h.01',
    A: 'M10 3l8 21H2zM10 14v4',
    R: 'M4 3v22M4 4h11l-7 8 9 12',
    I: 'M10 3v22M5 9h10M5 19h10',
    O: 'M18 14a8 8 0 1 1-16 0a8 8 0 1 1 16 0zM10 9v10',
    L: 'M5 3v22h11M10 9l5 5-5 5',
    B: 'M4 3v22M4 4l11 5-11 5M4 14l12 5-12 5',
    S: 'M16 3L4 10l12 7-12 8M16 25h.01',
  };
  const KIT = ['M10 3v22', 'M3 3l14 22', 'M17 3L3 25', 'M3 14h14', 'M4 4h12', 'M4 24h12',
    'M10 8a4 4 0 1 0 .01 0', 'M4 10l6-6 6 6', 'M4 18l6 6 6-6', 'M15 6h.01', 'M5 22h.01', 'M3 9l7 5-7 5'];
  function glyphPath(ch) {
    if (G[ch]) return G[ch];
    const c = ch.charCodeAt(0);
    return [KIT[c % 12], KIT[(c * 7 + 3) % 12], KIT[(c * 5 + 1) % 12]].join('');
  }

  /** SVG string for a word in the glyph script. */
  function glyphSVG(text, cls) {
    const chars = String(text).toUpperCase().split('');
    let x = 0, d = '';
    chars.forEach(ch => {
      if (ch !== ' ') d += `<path transform="translate(${x} 0)" d="${glyphPath(ch)}"/>`;
      x += ch === ' ' ? 16 : 24;
    });
    return `<svg class="glyph-svg ${cls || ''}" viewBox="-2 0 ${x + 2} 28" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${d}</svg>`;
  }

  function mountGlyphs(root) {
    (root || document).querySelectorAll('[data-glyph]:not([data-mounted])').forEach(el => {
      el.dataset.mounted = '1';
      el.innerHTML = glyphSVG(el.dataset.glyph);
      el.setAttribute('aria-hidden', 'true');
    });
  }

  window.NarioMonkey = { mount, blink, svg: monkeySVG };
  window.NarioGlyph = { svg: glyphSVG, mount: mountGlyphs };

  const boot = () => { mount(); mountGlyphs(); };
  document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();
})();
