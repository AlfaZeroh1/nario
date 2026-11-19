/* Nario Labs CMS: icons, colour swatches, drag-to-reorder. */
(function () {
  'use strict';
  const IC = {
    grid: 'M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z',
    handshake: 'M2 12l4-4 4 2 4-3 4 1 4 4-6 6-3-2-3 2-4-2z',
    users: 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8',
    layers: 'M12 2l10 5-10 5L2 7zM2 12l10 5 10-5M2 17l10 5 10-5',
    game: 'M6 11h4M8 9v4M15 11h.01M18 13h.01M7 6h10a5 5 0 0 1 5 5v3a4 4 0 0 1-7 2.6L14 16h-4l-1 .6A4 4 0 0 1 2 14v-3a5 5 0 0 1 5-5z',
    mail: 'M3 5h18v14H3zM3 6l9 7 9-7',
    cog: 'M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-2.9 1.2V21a2 2 0 1 1-4 0v-.1A1.7 1.7 0 0 0 7 19.4a1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A1.7 1.7 0 0 0 1.2 14H1a2 2 0 1 1 0-4h.1A1.7 1.7 0 0 0 4.6 7a1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1A1.7 1.7 0 0 0 10 1.2V1a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 2.9 1.2l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0 1.2 2.9H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z',
  };
  document.querySelectorAll('.ic').forEach(el => {
    const k = [...el.classList].find(c => c.startsWith('ic-'))?.slice(3);
    if (IC[k]) el.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="${IC[k]}"/></svg>`;
  });

  document.querySelectorAll('.swatch').forEach(b => b.addEventListener('click', () => {
    const input = b.closest('.color-row').querySelector('input[type=color]');
    input.value = b.dataset.color;
  }));

  const table = document.querySelector('table[data-sortable]');
  if (table) {
    const body = table.querySelector('tbody');
    let dragging = null;
    body.addEventListener('dragstart', e => { dragging = e.target.closest('tr'); dragging.classList.add('dragging'); });
    body.addEventListener('dragend', () => { dragging.classList.remove('dragging'); dragging = null; save(); });
    body.addEventListener('dragover', e => {
      e.preventDefault();
      const row = e.target.closest('tr');
      if (!row || row === dragging) return;
      const r = row.getBoundingClientRect();
      body.insertBefore(dragging, e.clientY > r.top + r.height / 2 ? row.nextSibling : row);
    });
    function save() {
      const fd = new FormData();
      fd.append('action', 'reorder');
      fd.append('csrf', table.dataset.csrf);
      body.querySelectorAll('tr').forEach(tr => fd.append('order[]', tr.dataset.id));
      fetch('items.php?type=' + encodeURIComponent(table.dataset.type), { method: 'POST', body: fd })
        .then(r => r.ok ? toast('Order saved') : toast('Could not save order', true))
        .catch(() => toast('Could not save order', true));
    }
  }
  function toast(msg, bad) {
    const t = document.createElement('div'); t.className = 'toast' + (bad ? ' bad' : ''); t.textContent = msg;
    document.body.appendChild(t); setTimeout(() => t.remove(), 2200);
  }
})();
