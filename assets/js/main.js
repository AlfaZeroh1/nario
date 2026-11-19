/* ==================================================================
 * NARIO LABS — interactions
 *  stars · aura · cursor + glow · glyph spotlight · sfx · preloader
 *  intro (word → monkey) · reveals · magnetic buttons · tilt cards
 *  spiral carousels · bento · games · bubbles · counters · contact form
 * ================================================================== */
(function () {
  'use strict';

  const qs = (s, r = document) => r.querySelector(s);
  const qsa = (s, r = document) => Array.from(r.querySelectorAll(s));
  const clamp = (v, a = 0, b = 1) => Math.min(b, Math.max(a, v));
  const lerp = (a, b, t) => a + (b - a) * t;
  const easeOut = t => 1 - Math.pow(1 - t, 3);
  const easeBack = t => { const c1 = 1.70158, c3 = c1 + 1; return 1 + c3 * Math.pow(t - 1, 3) + c1 * Math.pow(t - 1, 2); };
  const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const finePointer = matchMedia('(hover: hover) and (pointer: fine)').matches;
  const DATA = window.NARIO || {};
  const store = {
    get(k) { try { return localStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { localStorage.setItem(k, v); } catch (e) { } },
    sget(k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    sset(k, v) { try { sessionStorage.setItem(k, v); } catch (e) { } },
  };

  /* ---------------- Icons ---------------- */
  const IC = {
    arrow: 'M7 17L17 7M8 7h9v9',
    arrowR: 'M5 12h14M13 6l6 6-6 6',
    engine: 'M12 2l9 5v10l-9 5-9-5V7zM12 22V12M21 7l-9 5-9-5',
    flask: 'M9 3h6M10 3v6l-5 9a2 2 0 0 0 1.8 3h10.4A2 2 0 0 0 19 18l-5-9V3M7.5 14h9',
    code: 'M8 7l-5 5 5 5M16 7l5 5-5 5M14 4l-4 16',
    cloud: 'M7 18a5 5 0 1 1 1-9.9A6 6 0 0 1 19.5 10 4 4 0 0 1 18 18z',
    game: 'M6 11h4M8 9v4M15 11h.01M18 13h.01M7 6h10a5 5 0 0 1 5 5v3a4 4 0 0 1-7 2.6L14 16h-4l-1 .6A4 4 0 0 1 2 14v-3a5 5 0 0 1 5-5z',
    mail: 'M3 5h18v14H3zM3 6l9 7 9-7',
    phone: 'M5 3h4l2 5-2.5 1.5a11 11 0 0 0 6 6L16 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 5a2 2 0 0 1 2-2z',
    pin: 'M12 22s7-6.5 7-12a7 7 0 0 0-14 0c0 5.5 7 12 7 12zM12 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z',
    whatsapp: 'M3 21l1.6-4.7A9 9 0 1 1 8 19.6zM9 8.5c.3 2.8 3.7 6.2 6.5 6.5l1.2-1.6-2.1-1.1-1 1c-1.2-.5-2.4-1.7-2.9-2.9l1-1L10.6 7.3z',
    grid: 'M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z',
    ai: 'M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z',
    chart: 'M3 21h18M6 17v-7M11 17V5M16 17V9M21 17v-4',
    mobile: 'M7 2h10a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zM11 18h2',
    globe: 'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM3 12h18M12 3c3 3.5 3 14.5 0 18M12 3c-3 3.5-3 14.5 0 18',
    plug: 'M9 2v5M15 2v5M6 7h12v4a6 6 0 0 1-12 0zM12 17v5',
    cart: 'M3 4h2l2.5 11h11L21 7H6.2M9 20h.01M18 20h.01',
    wallet: 'M3 7h16a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zM3 7l13-4v4M17 13.5h.01',
    school: 'M2 9l10-5 10 5-10 5zM6 11v5c3 2.5 9 2.5 12 0v-5',
    health: 'M12 21s-8-5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6-8 11-8 11zM8 11h2l1.5-2.5L13 13l1.5-2H16',
    server: 'M3 4h18v6H3zM3 14h18v6H3zM7 7h.01M7 17h.01',
    spark: 'M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z',
    target: 'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zM12 11.5v1',
    users: 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8',
    rocket: 'M5 15c-1.5 1.5-2 5-2 5s3.5-.5 5-2M9 12l3 3M14.5 4.5C17 2 21 3 21 3s1 4-1.5 6.5L12 17l-5-5zM15 9h.01',
    shield: 'M12 2l8 3v6c0 5-3.5 9.5-8 11-4.5-1.5-8-6-8-11V5z',
    layers: 'M12 2l10 5-10 5L2 7zM2 12l10 5 10-5M2 17l10 5 10-5',
    brush: 'M4 20c3 0 5-2 5-5l9-9a2.1 2.1 0 0 0-3-3l-9 9c-3 0-5 2-5 5 0 2 1 3 3 3z',
    handshake: 'M2 12l4-4 4 2 4-3 4 1 4 4-6 6-3-2-3 2-4-2z',
    refresh: 'M21 12a9 9 0 1 1-3-6.7L21 8M21 3v5h-5',
    play: 'M6 4l14 8-14 8z',
    drag: 'M8 7l-5 5 5 5M16 7l5 5-5 5M3 12h18',
    instagram: 'M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zM12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM17.5 6.5h.01',
    x: 'M4 4l16 16M20 4L4 20',
    tiktok: 'M14 3v11.5a3.5 3.5 0 1 1-3.5-3.5M14 3c.5 3 2.5 5 6 5',
    linkedin: 'M4 9h3v11H4zM5.5 4.5h.01M10 20V9h3v1.5c.8-1.2 2-1.8 3.5-1.8 2.3 0 3.5 1.5 3.5 4.3v7h-3v-6.5c0-1.3-.6-2-1.8-2-1.3 0-2.2.9-2.2 2.3V20z',
    youtube: 'M2 8a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3zM10 9v6l5-3z',
    facebook: 'M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v6h4v-6h3l1-4h-4V8z',
    github: 'M9 19c-4 1.5-4-2-6-2.5M15 22v-3.9a3.4 3.4 0 0 0-1-2.6c3.2-.4 6.5-1.6 6.5-7a5.4 5.4 0 0 0-1.5-3.8 5 5 0 0 0-.1-3.8s-1.2-.4-3.9 1.5a13.4 13.4 0 0 0-7 0C5.3 1.6 4.1 2 4.1 2a5 5 0 0 0-.1 3.8A5.4 5.4 0 0 0 2.5 9.6c0 5.4 3.3 6.6 6.5 7a3.4 3.4 0 0 0-1 2.6V22',
  };
  const icon = (n, sw = 2) => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="${sw}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="${IC[n] || IC.spark}"/></svg>`;
  function mountIcons(root) { qsa('[data-icon]', root).forEach(el => { el.innerHTML = icon(el.dataset.icon); el.removeAttribute('data-icon'); }); }
  mountIcons();

  /* ---------------- Sound (Web Audio, no files) ---------------- */
  const Sfx = (() => {
    let ctx = null, master = null, drone = null, on = false, noiseBuf = null, lastWhoosh = 0, lastHover = 0;
    function init() {
      if (ctx) return;
      const AC = window.AudioContext || window.webkitAudioContext;
      if (!AC) return;
      ctx = new AC();
      master = ctx.createGain(); master.gain.value = .7; master.connect(ctx.destination);
      noiseBuf = ctx.createBuffer(1, ctx.sampleRate * 0.6, ctx.sampleRate);
      const d = noiseBuf.getChannelData(0); for (let i = 0; i < d.length; i++) d[i] = Math.random() * 2 - 1;
    }
    function tone(f1, f2, dur, type, vol, delay = 0) {
      if (!on || !ctx) return;
      const t = ctx.currentTime + delay, o = ctx.createOscillator(), g = ctx.createGain();
      o.type = type; o.frequency.setValueAtTime(f1, t); o.frequency.exponentialRampToValueAtTime(f2, t + dur);
      g.gain.setValueAtTime(0.0001, t); g.gain.exponentialRampToValueAtTime(vol, t + 0.008); g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
      o.connect(g).connect(master); o.start(t); o.stop(t + dur + .03);
    }
    function startDrone() {
      if (drone || !ctx) return;
      const g = ctx.createGain(); g.gain.value = 0; g.connect(master);
      const f = ctx.createBiquadFilter(); f.type = 'lowpass'; f.frequency.value = 380; f.Q.value = 6; f.connect(g);
      const oscs = [55, 82.4, 110.3].map((fr, i) => { const o = ctx.createOscillator(); o.type = i ? 'sawtooth' : 'sine'; o.frequency.value = fr; o.detune.value = i * 7; o.connect(f); o.start(); return o; });
      const lfo = ctx.createOscillator(), lg = ctx.createGain(); lfo.frequency.value = .07; lg.gain.value = 220; lfo.connect(lg).connect(f.frequency); lfo.start();
      g.gain.linearRampToValueAtTime(.022, ctx.currentTime + 3);
      drone = { g, oscs, lfo };
    }
    function stopDrone() {
      if (!drone) return;
      const d = drone; drone = null;
      d.g.gain.linearRampToValueAtTime(0, ctx.currentTime + .8);
      setTimeout(() => { d.oscs.forEach(o => o.stop()); d.lfo.stop(); }, 900);
    }
    return {
      get on() { return on; },
      set(state) {
        init(); if (!ctx) return;
        if (ctx.state === 'suspended') ctx.resume();
        on = !!state; store.set('nl_sound', on ? '1' : '0');
        on ? startDrone() : stopDrone();
        qsa('.sound-toggle').forEach(b => { b.classList.toggle('on', on); b.setAttribute('aria-pressed', on); const l = qs('.lbl', b); if (l) l.textContent = on ? 'Sound on' : 'Sound off'; });
      },
      pop() { tone(380, 920, .13, 'sine', .2); tone(760, 1500, .09, 'triangle', .05, .02); },
      hover() { const n = performance.now(); if (n - lastHover < 60) return; lastHover = n; tone(1700, 2300, .045, 'sine', .035); },
      tick() { tone(2600, 2100, .03, 'square', .012); },
      chime() { [523, 659, 784, 1047].forEach((f, i) => tone(f, f * 1.01, .5, 'sine', .07, i * .07)); },
      whoosh(intensity) {
        if (!on || !ctx) return;
        const n = performance.now(); if (n - lastWhoosh < 220) return; lastWhoosh = n;
        const t = ctx.currentTime, src = ctx.createBufferSource(), bp = ctx.createBiquadFilter(), g = ctx.createGain();
        src.buffer = noiseBuf; bp.type = 'bandpass'; bp.Q.value = 1.4;
        bp.frequency.setValueAtTime(300, t); bp.frequency.exponentialRampToValueAtTime(1600, t + .35);
        const v = clamp(intensity, .1, 1) * .07;
        g.gain.setValueAtTime(0.0001, t); g.gain.exponentialRampToValueAtTime(v, t + .08); g.gain.exponentialRampToValueAtTime(0.0001, t + .45);
        src.connect(bp).connect(g).connect(master); src.start(t); src.stop(t + .5);
      },
    };
  })();
  window.NarioSfx = Sfx;

  qsa('.sound-toggle').forEach(b => b.addEventListener('click', () => { Sfx.set(!Sfx.on); Sfx.pop(); }));
  // A visitor who chose sound before gets it back on their first interaction (browsers block audio until then).
  if (store.get('nl_sound') === '1') {
    const resume = () => { Sfx.set(true); window.removeEventListener('pointerdown', resume); window.removeEventListener('keydown', resume); };
    window.addEventListener('pointerdown', resume); window.addEventListener('keydown', resume);
  }
  document.addEventListener('pointerdown', e => { if (e.target.closest('a, button, .filter, label, summary')) Sfx.pop(); });
  document.addEventListener('pointerover', e => {
    const t = e.target.closest('a, button, .card, .filter, summary');
    if (t && !t.contains(e.relatedTarget)) Sfx.hover();
  });

  /* ---------------- Pointer state ---------------- */
  const P = { x: innerWidth / 2, y: innerHeight / 2, sx: innerWidth / 2, sy: innerHeight / 2, gx: innerWidth / 2, gy: innerHeight / 2, moved: false };
  if (finePointer) document.body.classList.add('has-cursor'); else document.body.classList.add('no-pointer');
  window.addEventListener('pointermove', e => { P.x = e.clientX; P.y = e.clientY; P.moved = true; }, { passive: true });

  const dot = qs('.cursor-dot'), ring = qs('.cursor-ring'), glow = qs('.cursor-glow');
  const ringLabel = ring ? qs('span', ring) : null;
  if (finePointer && ring) {
    document.addEventListener('pointerover', e => {
      const lab = e.target.closest('[data-cursor]');
      const hov = e.target.closest('a, button, .card, input, textarea, select, summary, .filter, label');
      ring.classList.toggle('is-label', !!lab);
      ring.classList.toggle('is-hover', !!hov && !lab);
      if (lab && ringLabel) ringLabel.textContent = lab.dataset.cursor;
    });
    window.addEventListener('pointerdown', () => ring.classList.add('is-down'));
    window.addEventListener('pointerup', () => ring.classList.remove('is-down'));
    document.addEventListener('mouseleave', () => { dot.style.opacity = ring.style.opacity = 0; });
    document.addEventListener('mouseenter', () => { dot.style.opacity = ring.style.opacity = 1; });
  }

  /* ---------------- Glyph field (Wakanda-inspired script in the background) ---------------- */
  function seeded(seed) { return () => { seed = (seed * 16807) % 2147483647; return (seed - 1) / 2147483646; }; }
  function sigil(size) {
    const ticks = Array.from({ length: 24 }, (_, i) => { const a = i / 24 * Math.PI * 2; const r1 = 40, r2 = i % 3 ? 44 : 48; return `M${50 + Math.cos(a) * r1} ${50 + Math.sin(a) * r1}L${50 + Math.cos(a) * r2} ${50 + Math.sin(a) * r2}`; }).join('');
    return `<svg viewBox="0 0 100 100" width="${size}" height="${size}" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="50" cy="50" r="36"/><circle cx="50" cy="50" r="22" stroke-dasharray="3 4"/><path d="${ticks}"/><path d="M50 28l19 33H31z"/><circle cx="50" cy="50" r="3" fill="currentColor"/></svg>`;
  }
  function buildGlyphs() {
    const layers = qsa('.glyphs');
    if (!layers.length || !window.NarioGlyph) return;
    const rnd = seeded(7 + (document.body.dataset.page || '').length * 13);
    const words = ['NARIO LABS', 'NARIO', 'LABS', 'NARIO LABS NARIO', 'ORIGIN'];
    let html = '';
    const rows = innerWidth < 700 ? 12 : 18;
    for (let i = 0; i < rows; i++) {
      const vertical = rnd() < .25;
      const h = Math.round(16 + rnd() * 34);
      const top = (i / rows) * 100 + rnd() * 4;
      const left = rnd() * 85 - 5;
      html += `<div class="gl" style="top:${top}%;left:${left}%;height:${h}px;transform:rotate(${vertical ? 90 : (rnd() * 10 - 5).toFixed(1)}deg);transform-origin:0 0">${NarioGlyph.svg(words[Math.floor(rnd() * words.length)])}</div>`;
    }
    for (let i = 0; i < 4; i++) {
      html += `<div class="sigil" style="top:${10 + rnd() * 75}%;left:${rnd() * 90}%">${sigil(120 + Math.round(rnd() * 140))}</div>`;
    }
    layers.forEach(l => { l.innerHTML = html; });
  }
  buildGlyphs();

  /* ---------------- Starfield ---------------- */
  const Stars = (() => {
    const c = qs('#stars'); if (!c) return { draw() { } };
    const ctx = c.getContext('2d');
    let w, h, dpr, stars = [], shoot = null;
    function resize() {
      dpr = Math.min(devicePixelRatio || 1, 2); w = innerWidth; h = innerHeight;
      c.width = w * dpr; c.height = h * dpr; ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      const n = Math.round(w * h / 5200);
      stars = Array.from({ length: n }, () => ({ x: Math.random() * w, y: Math.random() * h, z: Math.random() * .9 + .1, tw: Math.random() * Math.PI * 2, gold: Math.random() < .18 }));
    }
    resize(); addEventListener('resize', resize);
    return {
      draw(scrollY, t) {
        ctx.clearRect(0, 0, w, h);
        const mx = (P.sx / w - .5), my = (P.sy / h - .5);
        for (const s of stars) {
          let y = (s.y - scrollY * s.z * .25) % h; if (y < 0) y += h;
          const x = s.x - mx * 18 * s.z, yy = y - my * 18 * s.z;
          const a = .35 + .65 * Math.abs(Math.sin(t * .0012 * (1 + s.z) + s.tw));
          ctx.globalAlpha = a * s.z;
          ctx.fillStyle = s.gold ? '#ffd76a' : '#e9e6ff';
          const r = s.z * 1.3;
          ctx.fillRect(x, yy, r, r);
        }
        if (!shoot && Math.random() < .004) shoot = { x: Math.random() * w * .8 + w * .2, y: Math.random() * h * .4, l: 0 };
        if (shoot) {
          shoot.l += 14; const len = 120;
          const x = shoot.x - shoot.l, y = shoot.y + shoot.l * .45;
          const g = ctx.createLinearGradient(x, y, x + len, y - len * .45);
          g.addColorStop(0, 'rgba(255,223,126,.9)'); g.addColorStop(1, 'rgba(255,223,126,0)');
          ctx.globalAlpha = 1; ctx.strokeStyle = g; ctx.lineWidth = 1.5;
          ctx.beginPath(); ctx.moveTo(x, y); ctx.lineTo(x + len, y - len * .45); ctx.stroke();
          if (shoot.l > w) shoot = null;
        }
        ctx.globalAlpha = 1;
      },
    };
  })();

  /* ---------------- Smooth scroll ---------------- */
  let lenis = null;
  if (window.Lenis && !reduced) {
    lenis = new Lenis({ lerp: .09, smoothWheel: true, wheelMultiplier: 1 });
    window.NarioLenis = lenis;
    qsa('a[href^="#"]').forEach(a => a.addEventListener('click', e => { const t = qs(a.getAttribute('href')); if (t) { e.preventDefault(); lenis.scrollTo(t, { offset: -80 }); } }));
  }
  let lastY = scrollY, vel = 0;

  /* ---------------- Header: hide on scroll down, menu ---------------- */
  const header = qs('.site-header');
  const burger = qs('.burger');
  if (burger) burger.addEventListener('click', () => {
    const open = document.body.classList.toggle('menu-open');
    burger.setAttribute('aria-expanded', open);
    open ? lenis?.stop() : lenis?.start();
  });
  qsa('.mobile-menu a').forEach((a, i) => { a.style.setProperty('--i', i); });

  /* ---------------- Text splitting & reveals ---------------- */
  qsa('[data-split]').forEach(el => {
    let i = 0;
    const walk = node => {
      Array.from(node.childNodes).forEach(n => {
        if (n.nodeType === 3) {
          const frag = document.createDocumentFragment();
          n.textContent.split(/(\s+)/).forEach(part => {
            if (!part) return;
            if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(' ')); return; }
            const w = document.createElement('span'); w.className = 'w';
            const inner = document.createElement('span'); inner.textContent = part; inner.style.setProperty('--i', i++);
            w.appendChild(inner); frag.appendChild(w);
          });
          n.replaceWith(frag);
        } else if (n.nodeType === 1 && !n.classList.contains('chip-in')) walk(n);
        else if (n.nodeType === 1) { const w = document.createElement('span'); w.className = 'w'; const inner = document.createElement('span'); inner.style.setProperty('--i', i++); n.replaceWith(w); inner.appendChild(n); w.appendChild(inner); }
      });
    };
    walk(el); el.classList.add('split');
  });

  const io = new IntersectionObserver(entries => {
    entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
  }, { threshold: .15, rootMargin: '0px 0px -6% 0px' });
  function observe(root) { qsa('.reveal, .pop, .split', root).forEach(el => io.observe(el)); }

  // Scroll-scrubbed statement: words light up as you scroll
  const scrubs = qsa('[data-scrub]').map(el => {
    const words = [];
    const walk = node => Array.from(node.childNodes).forEach(n => {
      if (n.nodeType === 3) {
        const frag = document.createDocumentFragment();
        n.textContent.split(/(\s+)/).forEach(part => {
          if (!part) return;
          if (/^\s+$/.test(part)) return frag.appendChild(document.createTextNode(' '));
          const s = document.createElement('span'); s.className = 'dimw'; s.textContent = part; words.push(s); frag.appendChild(s);
        });
        n.replaceWith(frag);
      } else if (n.nodeType === 1 && !n.classList.contains('chip-in')) walk(n);
    });
    walk(el);
    return { el, words, lit: -1 };
  });

  /* ---------------- Magnetic buttons + tilt cards ---------------- */
  function bindInteractive(root) {
    if (!finePointer) return;
    qsa('.btn, [data-magnetic]', root).forEach(b => {
      if (b.dataset.bound) return; b.dataset.bound = 1;
      b.addEventListener('pointermove', e => {
        const r = b.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top;
        b.style.setProperty('--tx', ((x - r.width / 2) * .22).toFixed(1) + 'px');
        b.style.setProperty('--ty', ((y - r.height / 2) * .3).toFixed(1) + 'px');
        b.style.setProperty('--bx', x + 'px'); b.style.setProperty('--by', y + 'px');
      });
      b.addEventListener('pointerleave', () => { b.style.setProperty('--tx', '0px'); b.style.setProperty('--ty', '0px'); });
    });
    qsa('.card', root).forEach(c => {
      if (c.dataset.bound) return; c.dataset.bound = 1;
      const tilt = c.hasAttribute('data-tilt');
      c.addEventListener('pointermove', e => {
        const r = c.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top;
        c.style.setProperty('--x', x + 'px'); c.style.setProperty('--y', y + 'px');
        if (tilt) { c.style.transition = 'transform .15s ease-out, border-color .4s, box-shadow .4s'; c.style.transform = `perspective(900px) rotateX(${((.5 - y / r.height) * 7).toFixed(2)}deg) rotateY(${((x / r.width - .5) * 9).toFixed(2)}deg) scale(1.015)`; }
      });
      c.addEventListener('pointerleave', () => { if (tilt) { c.style.transition = ''; c.style.transform = ''; } });
    });
  }

  /* ---------------- Counters ---------------- */
  const cio = new IntersectionObserver(entries => entries.forEach(en => {
    if (!en.isIntersecting) return;
    const el = en.target, to = +el.dataset.count, from = +(el.dataset.from || 0), t0 = performance.now(), dur = 1800;
    const step = t => { const p = clamp((t - t0) / dur); el.textContent = Math.round(lerp(from, to, easeOut(p))) + (el.dataset.suffix || ''); if (p < 1) requestAnimationFrame(step); };
    requestAnimationFrame(step); cio.unobserve(el);
  }), { threshold: .5 });
  qsa('[data-count]').forEach(el => cio.observe(el));

  /* ---------------- Bubble avatars ---------------- */
  const BUBBLE_COLORS = ['#f4c542', '#22e3c9', '#ff4fa3', '#8c6bff', '#4fc3ff', '#ff9f1c', '#c6ff4f'];
  function avatar(kind) {
    const eyes = '<ellipse class="ava-eye" cx="38" cy="48" rx="6" ry="7" fill="#05050a"/><ellipse class="ava-eye" cx="62" cy="48" rx="6" ry="7" fill="#05050a"/>';
    if (kind === 0) return `<svg viewBox="0 0 100 100"><path d="M20 30h60v40a12 12 0 0 1-12 12H32a12 12 0 0 1-12-12z" fill="rgba(0,0,0,.18)"/>${eyes}<path d="M40 66q10 8 20 0" stroke="#05050a" stroke-width="4" fill="none" stroke-linecap="round"/><path d="M50 30V16" stroke="#05050a" stroke-width="4" stroke-linecap="round"/><circle cx="50" cy="13" r="5" fill="#05050a"/></svg>`;
    if (kind === 1) return `<svg viewBox="0 0 100 100"><circle cx="50" cy="52" r="34" fill="rgba(255,255,255,.35)"/><rect x="24" y="38" width="52" height="24" rx="12" fill="#05050a"/><ellipse class="ava-eye" cx="40" cy="50" rx="5" ry="6" fill="#ffdf7e"/><ellipse class="ava-eye" cx="60" cy="50" rx="5" ry="6" fill="#ffdf7e"/></svg>`;
    if (kind === 2) return `<svg viewBox="0 0 100 100"><path d="M18 40l14-14h36l14 14v26L66 82H34L18 66z" fill="rgba(0,0,0,.15)"/>${eyes}<path d="M42 66l8 6 8-6" stroke="#05050a" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
    return `<svg viewBox="0 0 100 100"><circle cx="50" cy="50" r="30" fill="rgba(0,0,0,.12)"/>${eyes}<circle cx="50" cy="66" r="5" fill="#05050a"/><path d="M14 44q-4 10 4 16M86 44q4 10-4 16" stroke="#05050a" stroke-width="4" fill="none" stroke-linecap="round"/></svg>`;
  }
  qsa('[data-bubbles]').forEach(box => {
    const spots = (box.dataset.bubbles || '8,12;88,8;92,62;4,70;70,88;40,96').split(';').map(s => s.split(',').map(Number));
    spots.forEach(([x, y], i) => {
      const b = document.createElement('div'); b.className = 'bubble pop';
      b.style.cssText = `left:${x}%;top:${y}%;--c:${BUBBLE_COLORS[i % BUBBLE_COLORS.length]};--sz:${56 + (i * 17) % 40}px;--t:${5 + i % 4}s;--dl:${-i * .7}s;--d:${i * 120}`;
      b.innerHTML = avatar(i % 4);
      box.appendChild(b);
    });
  });

  /* ---------------- Orbit map (mother factory diagram) ---------------- */
  qsa('[data-orbitmap]').forEach(map => {
    const nodes = qsa('.om-node', map);
    const svg = qs('svg.lines', map);
    let d = '';
    nodes.forEach((n, i) => {
      const a = (i / nodes.length) * Math.PI * 2 - Math.PI / 2;
      const x = 50 + Math.cos(a) * 40, y = 50 + Math.sin(a) * 40;
      n.style.left = x + '%'; n.style.top = y + '%'; n.style.setProperty('--dl', (-i * 1.1) + 's');
      const cx = 50 + Math.cos(a + .5) * 20, cy = 50 + Math.sin(a + .5) * 20;
      d += `M50 50Q${cx.toFixed(1)} ${cy.toFixed(1)} ${x.toFixed(1)} ${y.toFixed(1)}`;
    });
    if (svg) svg.innerHTML = `<path d="${d}" vector-effect="non-scaling-stroke"/>`;
  });

  /* ---------------- Content renderers (CMS data) ---------------- */
  const h = (tag, cls, txt) => { const el = document.createElement(tag); if (cls) el.className = cls; if (txt != null) el.textContent = txt; return el; };
  const initials = name => String(name).split(/\s+/).map(w => w[0]).join('').slice(0, 2).toUpperCase();
  const domain = url => { try { return new URL(url).hostname.replace(/^www\./, ''); } catch (e) { return ''; } };
  const ACCENTS = ['#f4c542', '#22e3c9', '#ff4fa3', '#8c6bff', '#4fc3ff', '#ff9f1c', '#c6ff4f'];
  const accentOf = (it, i) => it.accent || ACCENTS[i % ACCENTS.length];

  function logoBox(it, cls) {
    const box = h('div', cls);
    if (it.logo) { const img = h('img'); img.src = it.logo; img.alt = it.name + ' logo'; img.loading = 'lazy'; box.appendChild(img); }
    else { box.classList.add('mono'); box.textContent = initials(it.name); }
    return box;
  }

  function renderBento(el) {
    const items = (DATA.product || []).slice(0, +(el.dataset.limit || 99));
    el.innerHTML = '';
    items.forEach((it, i) => {
      const url = it.url || ('contact.php?interest=partner&product=' + encodeURIComponent(it.name));
      const a = h('a', `card b-card ${it.size || 'sm'} reveal`);
      a.href = url; if (it.url) { a.target = '_blank'; a.rel = 'noopener'; }
      a.dataset.cat = it.category || '';
      a.dataset.cursor = it.url ? 'Visit' : 'Partner';
      a.setAttribute('data-tilt', '');
      a.style.setProperty('--accent', accentOf(it, i)); a.style.setProperty('--d', (i % 4) * 90);
      const top = h('div', 'b-top'); top.appendChild(logoBox(it, 'b-logo'));
      if (it.status) top.appendChild(h('span', 'status', it.status));
      const gl = h('div', 'b-glyph'); gl.innerHTML = window.NarioGlyph ? NarioGlyph.svg(initials(it.name)) : '';
      const body = h('div', 'b-body');
      if (it.category) body.appendChild(h('div', 'b-cat', it.category));
      body.appendChild(h('h3', 'b-name', it.name));
      if (it.tagline) body.appendChild(h('p', 'b-tag', it.tagline));
      const go = h('span', 'b-go'); go.innerHTML = icon('arrow', 2.4);
      a.append(top, gl, body, go);
      el.appendChild(a);
    });
    if (el.dataset.cta !== undefined) {
      const c = h('a', 'card b-card wide cta-card reveal'); c.href = 'partners.php'; c.dataset.cursor = 'Join';
      c.innerHTML = `<div class="b-cat" style="color:#3a2c00">Distribution program</div><div><h3 class="b-name">Sell these under your brand</h3><p>Pick an engine, put your name on it, and we keep it running.</p></div>`;
      const go = h('span', 'b-go'); go.style.cssText = 'background:#140e00;color:#f4c542;transform:none'; go.innerHTML = icon('arrow', 2.4); c.appendChild(go);
      el.appendChild(c);
    }
    if (!items.length) el.innerHTML = '<p class="muted">Products are being added. Check back soon.</p>';
    // filters
    const fbox = el.dataset.filters ? qs(el.dataset.filters) : null;
    if (fbox) {
      const cats = ['All', ...new Set(items.map(i => i.category).filter(Boolean))];
      fbox.innerHTML = '';
      cats.forEach((c, i) => {
        const b = h('button', 'filter' + (i ? '' : ' is-on'), c); b.type = 'button';
        b.addEventListener('click', () => {
          qsa('.filter', fbox).forEach(x => x.classList.toggle('is-on', x === b));
          qsa('.b-card', el).forEach(card => {
            const show = c === 'All' || card.dataset.cat === c || card.classList.contains('cta-card');
            card.classList.toggle('is-hidden', !show);
            if (show) { card.classList.remove('in'); requestAnimationFrame(() => requestAnimationFrame(() => card.classList.add('in'))); }
          });
        });
        fbox.appendChild(b);
      });
    }
    observe(el); bindInteractive(el);
  }

  function ridge(seed) {
    const path = (off, amp) => {
      let d = 'M0 100';
      for (let x = 0; x <= 100; x += 10) d += ` L${x} ${(off + Math.sin(x * .7 + seed.length * (amp / 10)) * amp + (x % 20 ? 8 : 0)).toFixed(1)}`;
      return d + ' L100 100Z';
    };
    return `<svg class="ridge" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="${path(40, 16)}" fill="#05050a" opacity=".75"/><path d="${path(62, 10)}" fill="#000"/></svg>`;
  }
  function renderGames(el) {
    const items = (DATA.game || []).slice(0, +(el.dataset.limit || 99));
    el.innerHTML = '';
    items.forEach((it, i) => {
      const card = h(it.url ? 'a' : 'div', 'game-card reveal');
      if (it.url) { card.href = it.url; card.target = '_blank'; card.rel = 'noopener'; card.dataset.cursor = 'Play'; }
      card.setAttribute('data-tilt', ''); card.classList.add('card');
      card.style.setProperty('--accent', accentOf(it, i)); card.style.setProperty('--d', i * 120);
      const cover = h('div', 'game-cover' + (it.logo ? '' : ' gen'));
      if (it.logo) cover.style.backgroundImage = `url("${encodeURI(it.logo)}")`;
      else cover.innerHTML = `<div class="gglyph">${window.NarioGlyph ? NarioGlyph.svg(initials(it.name)) : ''}</div>${ridge(it.name)}`;
      const info = h('div', 'game-info');
      if (it.status) info.appendChild(h('span', 'status', it.status));
      info.appendChild(h('h3', '', it.name));
      if (it.tagline) info.appendChild(h('p', '', it.tagline));
      if (it.category) info.appendChild(h('div', 'platforms', it.category));
      card.append(cover, info);
      el.appendChild(card);
    });
    if (!items.length) el.innerHTML = '<p class="muted">Our first titles are in the forge. Follow us to be first in line.</p>';
    observe(el); bindInteractive(el);
  }

  /* ---------------- Helix (spiral carousel) ---------------- */
  class Helix {
    constructor(el) {
      this.el = el;
      const src = DATA[el.dataset.helix] || [];
      this.stage = qs('.helix-stage', el);
      if (!src.length) {
        el.innerHTML = `<div class="helix-empty"><p class="lead" style="margin:0">${el.dataset.empty || 'Coming soon.'}</p><a class="btn" href="contact.php"><span>Talk to us</span><span class="ico">${icon('arrow')}</span></a></div>`;
        el.style.height = 'auto'; this.dead = true; return;
      }
      // Fill the spiral: repeat entries so it never looks empty. Only first copies get a live iframe.
      const min = innerWidth < 640 ? 10 : 14;
      // Each repeat is rotated by a different offset so the same entry never stacks in one column.
      const u = src.length, total = Math.max(min, u);
      this.items = Array.from({ length: total }, (_, k) => {
        const copy = Math.floor(k / u), i = (k + copy * Math.max(1, Math.floor(u / 2))) % u;
        return { it: src[i], i, dup: k >= u };
      });
      this.cards = this.items.map(({ it, i, dup }, k) => this.card(it, i, dup, k));
      this.rot = 0; this.vel = 0; this.base = -.12; this.drag = null; this.front = -1; this.active = false; this.phase = 0; this.loaded = false;
      this.layout(); addEventListener('resize', () => this.layout());
      this.bind();
      new IntersectionObserver(([en]) => {
        this.active = en.isIntersecting;
        if (this.active && !this.loaded) { this.loaded = true; this.cards.forEach(c => { if (c.iframe) c.iframe.src = c.iframe.dataset.src; }); }
      }, { rootMargin: '200px' }).observe(el);
      this.timer = setInterval(() => this.alternate(), 3200);
    }
    card(it, i, dup, k) {
      const a = h('a', 'helix-card');
      if (it.url) { a.href = it.url; a.target = '_blank'; a.rel = 'noopener'; }
      a.setAttribute('aria-label', `${it.name} — open website in a new tab`);
      a.dataset.cursor = 'Open';
      a.style.setProperty('--accent', it.accent || ACCENTS[i % ACCENTS.length]);
      const inner = h('div', 'hc-inner');
      const logo = h('div', 'hc-logo');
      if (it.logo) { const img = h('img'); img.src = it.logo; img.alt = ''; img.loading = 'lazy'; img.draggable = false; logo.appendChild(img); }
      else logo.appendChild(h('span', 'hc-mono', initials(it.name)));
      const site = h('div', 'hc-site');
      site.innerHTML = `<div class="hc-chrome"><i></i><i></i><i></i><span></span></div>`;
      qs('span', site).textContent = domain(it.url) || it.name;
      let iframe = null;
      if (it.preview) { const img = h('img'); img.src = it.preview; img.alt = ''; img.loading = 'lazy'; img.draggable = false; site.appendChild(img); }
      else if (it.url && it.embed !== false && !dup) {
        iframe = h('iframe'); iframe.dataset.src = it.url; iframe.title = it.name + ' website preview';
        iframe.setAttribute('sandbox', 'allow-scripts allow-same-origin');
        iframe.setAttribute('tabindex', '-1'); iframe.setAttribute('aria-hidden', 'true');
        iframe.referrerPolicy = 'no-referrer';
        const fb = h('div', 'fallback'); fb.innerHTML = '<div></div>'; fb.firstChild.textContent = it.name; const sm = h('small', '', domain(it.url)); fb.firstChild.appendChild(sm);
        site.append(fb, iframe);
      } else {
        const fb = h('div', 'fallback'); fb.innerHTML = '<div></div>'; fb.firstChild.textContent = it.name; const sm = h('small', '', domain(it.url) || it.tagline || ''); fb.firstChild.appendChild(sm);
        site.appendChild(fb);
      }
      const cap = h('div', 'hc-cap'); cap.appendChild(h('b', '', it.name)); const ic = h('i'); ic.innerHTML = icon('arrow', 2.6); cap.appendChild(ic);
      inner.append(logo, site, cap); a.appendChild(inner);
      a.addEventListener('click', e => { if (this.moved) { e.preventDefault(); } else if (!it.url) e.preventDefault(); });
      a.addEventListener('pointerenter', () => { a.classList.add('show-site'); });
      a.addEventListener('pointerleave', () => { a.classList.toggle('show-site', (k + this.phase) % 2 === 0); });
      this.stage.appendChild(a);
      return { a, iframe, k };
    }
    layout() {
      const w = this.el.clientWidth, H = this.el.clientHeight;
      const cw = parseFloat(getComputedStyle(this.el).getPropertyValue('--cw')) || 260;
      const ch = parseFloat(getComputedStyle(this.el).getPropertyValue('--ch')) || 172;
      this.R = clamp(w * .36, 200, 560);
      this.perTurn = clamp(Math.round((2 * Math.PI * this.R) / (cw * 1.18)), 6, 12);
      this.step = 360 / this.perTurn;
      this.T = this.cards.length * this.step;
      this.pitch = clamp((H - ch * 1.3) / (this.T / 360), ch * 1.15, ch * 2.2);
      this.cards.forEach(c => c.a.style.setProperty('--sc', (cw / 1280).toFixed(4)));
      this.cards.forEach(c => { const f = qs('iframe', c.a); if (f) f.style.transform = `scale(${cw / 1280})`; });
    }
    bind() {
      const el = this.el;
      el.addEventListener('pointerdown', e => {
        this.drag = { x: e.clientX, last: e.clientX, t: performance.now() }; this.moved = false;
      });
      addEventListener('pointermove', e => {
        if (!this.drag) return;
        const dx = e.clientX - this.drag.last; this.drag.last = e.clientX;
        if (Math.abs(e.clientX - this.drag.x) > 6) this.moved = true;
        this.rot += dx * .28; this.vel = dx * .28;
      });
      addEventListener('pointerup', () => { if (this.drag) { this.drag = null; setTimeout(() => this.moved = false, 30); } });
      el.addEventListener('pointerenter', () => { this.hover = true; });
      el.addEventListener('pointerleave', () => { this.hover = false; });
    }
    alternate() {
      if (!this.active || this.dead) return;
      this.phase ^= 1;
      this.cards.forEach((c, i) => setTimeout(() => { if (!c.a.matches(':hover')) c.a.classList.toggle('show-site', (c.k + this.phase) % 2 === 0); }, i * 70));
    }
    frame(scrollVel) {
      if (!this.active || this.dead) return;
      if (!this.drag) {
        const target = this.hover ? this.base * .25 : this.base;
        this.vel = lerp(this.vel, target, .04);
        this.rot += this.vel + scrollVel * .06;
      }
      const T = this.T, half = T / 2, fadeW = this.step * 1.4;
      let front = -1, best = 999;
      this.cards.forEach((c, i) => {
        let a = ((i * this.step + this.rot) % T + T) % T - half; // −T/2 … T/2
        const y = -a / 360 * this.pitch;
        const rad = a * Math.PI / 180, depth = Math.cos(rad);
        const edge = clamp((half - Math.abs(a)) / fadeW);
        c.a.style.transform = `translate3d(0, ${y.toFixed(1)}px, 0) rotateY(${a.toFixed(2)}deg) translateZ(${this.R}px)`;
        c.a.style.opacity = (edge * (.28 + .72 * (depth + 1) / 2)).toFixed(3);
        c.a.style.pointerEvents = edge > .5 && depth > -.2 ? '' : 'none';
        const back = depth < 0;
        if (back !== c.back) { c.back = back; c.a.classList.toggle('back', back); }
        const dist = Math.abs(((a % 360) + 540) % 360 - 180);
        if (dist < best && edge > .6) { best = dist; front = i; }
      });
      if (front !== this.front) {
        if (this.front >= 0) this.cards[this.front].a.classList.remove('front');
        if (front >= 0) { this.cards[front].a.classList.add('front'); if (this.front >= 0) Sfx.tick(); }
        this.front = front;
      }
    }
  }

  /* ---------------- Intro: NARIO LABS → monkey ---------------- */
  const intro = qs('.intro');
  let introParts = null;
  if (intro) {
    const word = qs('.intro-word', intro);
    const text = word.textContent.trim(); word.textContent = '';
    let i = 0;
    text.split('').forEach(ch => {
      if (ch === ' ') { word.appendChild(h('span', 'gap')); return; }
      const outer = h('span', 'ch'); const inner = h('span', 'ch-in', ch); inner.style.setProperty('--i', i++);
      outer.appendChild(inner);
      outer._v = { x: (Math.random() - .5) * 2.2, y: (Math.random() - .3) * 1.6, r: (Math.random() - .5) * 90, z: Math.random() };
      word.appendChild(outer);
    });
    introParts = {
      word, chars: qsa('.ch', word), monkey: qs('.intro-monkey', intro), halo: qs('.intro-halo', intro),
      orbits: qs('.orbits', intro), tag: qs('.intro-tag', intro), meta: qs('.intro-meta', intro),
    };
  }
  function updateIntro() {
    if (!introParts) return;
    const r = intro.getBoundingClientRect();
    const p = reduced ? .8 : clamp(-r.top / (r.height - innerHeight));
    const I = introParts, W = innerWidth, H = innerHeight;
    const p1 = easeOut(clamp(p / .38));
    I.chars.forEach(c => {
      const v = c._v;
      c.style.transform = `translate3d(${(v.x * p1 * W * .6).toFixed(1)}px, ${(v.y * p1 * H * .7).toFixed(1)}px, 0) rotate(${(v.r * p1).toFixed(1)}deg) scale(${(1 + v.z * p1 * .8).toFixed(3)})`;
      c.style.opacity = (1 - p1 * 1.15).toFixed(3);
    });
    const p2 = clamp((p - .16) / .38);
    const s = .3 + .7 * easeBack(p2);
    I.monkey.style.opacity = clamp(p2 * 1.6).toFixed(3);
    I.monkey.style.transform = `scale(${s.toFixed(3)}) rotate(${((1 - p2) * -14).toFixed(2)}deg) translateY(${(-(clamp((p - .55) / .3)) * 14).toFixed(1)}vh)`;
    I.halo.style.opacity = (p2 * .9).toFixed(3);
    I.halo.style.transform = `scale(${(.6 + p2 * .5).toFixed(3)})`;
    I.orbits.style.opacity = (p2 * .9).toFixed(3);
    I.orbits.style.transform = `scale(${(.5 + p2 * .6).toFixed(3)}) rotate(${(p * 40).toFixed(1)}deg)`;
    const p3 = easeOut(clamp((p - .56) / .26));
    I.tag.style.opacity = p3.toFixed(3);
    I.tag.style.transform = `translateY(${((1 - p3) * 50).toFixed(1)}px)`;
    I.tag.style.pointerEvents = p3 > .5 ? 'auto' : 'none';
    I.meta.style.opacity = (1 - clamp(p * 4)).toFixed(3);
    if (p2 > .2 && !I.blinked) { I.blinked = true; const svg = qs('.monkey', I.monkey); if (svg && window.NarioMonkey) setTimeout(() => NarioMonkey.blink(svg, true), 350); Sfx.chime(); }
    if (p2 < .05) I.blinked = false;
  }

  /* ---------------- Contact form ---------------- */
  qsa('form[data-contact]').forEach(form => {
    const params = new URLSearchParams(location.search);
    const interest = params.get('interest');
    if (interest) { const r = qs(`input[name="interest"][value="${CSS.escape(interest)}"]`, form); if (r) r.checked = true; }
    const product = params.get('product');
    if (product) { const m = qs('textarea[name="message"]', form); if (m && !m.value) m.value = `I'm interested in distributing ${product}. `; }
    if (!qs('input[name="csrf"]', form) && DATA.csrf) { const c = h('input'); c.type = 'hidden'; c.name = 'csrf'; c.value = DATA.csrf; form.appendChild(c); }
    const status = qs('.form-status', form), btn = qs('button[type="submit"]', form);
    form.addEventListener('submit', async e => {
      e.preventDefault();
      qsa('.field', form).forEach(f => { f.classList.remove('err'); const m = qs('.msg', f); if (m) m.remove(); });
      status.className = 'form-status'; btn.disabled = true; const old = qs('span', btn).textContent; qs('span', btn).textContent = 'Sending…';
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'Accept': 'application/json' } });
        const j = await res.json().catch(() => ({ ok: false, error: 'Something went wrong. Please email or WhatsApp us.' }));
        if (j.ok) { status.className = 'form-status ok'; status.textContent = j.message || 'Sent!'; form.reset(); Sfx.chime(); }
        else {
          status.className = 'form-status bad'; status.textContent = j.error || 'Could not send.';
          Object.entries(j.fields || {}).forEach(([k, msg]) => { const inp = qs(`[name="${k}"]`, form); const f = inp && inp.closest('.field'); if (f) { f.classList.add('err'); f.appendChild(h('span', 'msg', msg)); } });
        }
      } catch (err) { status.className = 'form-status bad'; status.textContent = 'Network error. Please email or WhatsApp us instead.'; }
      btn.disabled = false; qs('span', btn).textContent = old;
    });
  });

  /* ---------------- Render CMS-driven blocks ---------------- */
  qsa('[data-bento]').forEach(renderBento);
  qsa('[data-games]').forEach(renderGames);
  const helices = qsa('[data-helix]').map(el => new Helix(el));
  if (window.NarioMonkey) NarioMonkey.mount();
  if (window.NarioGlyph) NarioGlyph.mount();
  mountIcons();
  observe(document); bindInteractive(document);
  qsa('.year').forEach(y => { y.textContent = new Date().getFullYear(); });

  /* ---------------- Preloader ---------------- */
  const pl = qs('.preloader');
  function ready() {
    document.body.classList.remove('is-loading'); document.body.classList.add('is-ready');
    if (pl) { pl.classList.add('out'); setTimeout(() => pl.remove(), 1200); }
    lenis?.start();
  }
  if (pl) {
    lenis?.stop();
    const count = qs('.pl-count', pl), bar = qs('.pl-bar i', pl);
    const ask = pl.dataset.ask === '1' && !store.sget('nl_entered');
    const t0 = performance.now(), dur = ask ? 1500 : 900;
    const tick = t => {
      const p = clamp((t - t0) / dur), v = Math.round(easeOut(p) * 100);
      count.textContent = v; bar.style.width = v + '%';
      if (p < 1) return requestAnimationFrame(tick);
      if (ask) {
        pl.classList.add('ask');
        qsa('[data-enter]', pl).forEach(b => b.addEventListener('click', () => {
          store.sset('nl_entered', '1');
          if (b.dataset.enter === 'sound') { Sfx.set(true); Sfx.chime(); } else Sfx.set(false);
          ready();
        }));
      } else setTimeout(ready, 150);
    };
    requestAnimationFrame(tick);
  } else ready();

  /* ---------------- Main loop ---------------- */
  let wander = 0;
  const root = document.documentElement;
  function loop(t) {
    lenis?.raf(t);
    const y = lenis ? lenis.scroll : scrollY;
    const dy = y - lastY; lastY = y;
    vel = lerp(vel, dy, .2);

    // pointer smoothing
    if (!finePointer) { wander += .004; P.x = innerWidth * (.5 + .38 * Math.sin(wander * 1.3)); P.y = innerHeight * (.5 + .34 * Math.sin(wander * 2.1 + 1)); }
    P.sx = lerp(P.sx, P.x, .35); P.sy = lerp(P.sy, P.y, .35);
    P.gx = lerp(P.gx, P.x, .08); P.gy = lerp(P.gy, P.y, .08);
    if (dot) dot.style.transform = `translate3d(${P.x}px, ${P.y}px, 0)`;
    if (ring) ring.style.transform = `translate3d(${P.sx}px, ${P.sy}px, 0)`;
    if (glow) glow.style.transform = `translate3d(${P.gx}px, ${P.gy}px, 0)`;
    root.style.setProperty('--mx', P.gx.toFixed(1) + 'px');
    root.style.setProperty('--my', P.gy.toFixed(1) + 'px');

    // header
    if (header) header.classList.toggle('is-hidden', y > 260 && dy > 2 && !document.body.classList.contains('menu-open') ? true : (dy < -2 ? false : header.classList.contains('is-hidden')));

    if (Math.abs(vel) > 14) Sfx.whoosh(Math.abs(vel) / 60);
    if (!reduced) Stars.draw(y, t);
    updateIntro();
    helices.forEach(hx => hx.frame(vel));

    scrubs.forEach(s => {
      const r = s.el.getBoundingClientRect();
      const p = clamp((innerHeight * .85 - r.top) / (r.height + innerHeight * .4));
      const n = Math.round(p * s.words.length);
      if (n !== s.lit) { s.words.forEach((w, i) => w.classList.toggle('lit', i < n)); s.lit = n; }
    });
    requestAnimationFrame(loop);
  }
  requestAnimationFrame(loop);
  if (reduced) Stars.draw(0, 0);
})();
