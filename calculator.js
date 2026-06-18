/* ─────────────────────────────────────────────────────
   GBL Peptide — calculator.js (full page calculator)
───────────────────────────────────────────────────── */

(function () {
  'use strict';

  /* ── TAB SWITCHING ── */
  const calcTabs  = document.querySelectorAll('.calc-tab');
  const calcModes = { recon: null, reverse: null, nasal: null };

  Object.keys(calcModes).forEach((k) => {
    calcModes[k] = document.getElementById('mode-' + k);
  });

  calcTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      const mode = tab.dataset.mode;
      calcTabs.forEach((t) => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      Object.values(calcModes).forEach((m) => { if (m) m.style.display = 'none'; });

      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');
      if (calcModes[mode]) calcModes[mode].style.display = 'block';
    });
  });

  /* ────────────────────────────────────────────────────
     RECONSTITUTION CALCULATOR
  ──────────────────────────────────────────────────── */
  const rBtn = document.getElementById('r-calc-btn');
  if (rBtn) {
    rBtn.addEventListener('click', calcRecon);

    // Live recalc on Enter
    ['r-vial','r-bac','r-dose','r-syringe'].forEach((id) => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('keydown', (e) => { if (e.key === 'Enter') calcRecon(); });
    });
  }

  function calcRecon() {
    const vial     = parseFloat(v('r-vial'));
    const bac      = parseFloat(v('r-bac'));
    const dose     = parseFloat(v('r-dose'));
    const syringe  = parseInt(v('r-syringe'), 10) || 100;

    if (!vial || !bac || !dose) {
      showError('recon', 'Please complete all three fields above.');
      return;
    }

    const conc     = (vial * 1000) / bac;          // mcg / mL
    const vol      = dose / conc;                    // mL
    const units    = vol * syringe;                  // IU
    const doses    = Math.floor((vial * 1000) / dose);

    set('r-volume', fmt(vol, 3) + '<span class="unit">mL</span>');
    set('r-units',  fmt(units, 1) + '<span class="unit">IU</span>');
    set('r-conc',   fmt(conc, 0) + '<span class="unit">mcg/mL</span>');
    set('r-doses',  doses + '<span class="unit">doses</span>');

    show('r-results');

    drawSyringe('r-syringe-canvas', vol / (syringe === 50 ? 0.5 : 1), syringe);
    buildRefTable(conc, syringe);
  }

  function buildRefTable(conc, syringe) {
    const tbody = document.getElementById('r-ref-tbody');
    if (!tbody) return;

    const base   = parseFloat(v('r-dose')) || 250;
    const multis = [0.5, 1, 1.5, 2, 3, 4];

    tbody.innerHTML = '';
    multis.forEach((m) => {
      const d   = base * m;
      const vol  = d / conc;
      const u    = vol * syringe;
      const tr   = document.createElement('tr');
      tr.style.borderBottom = '1px solid rgba(255,255,255,.06)';

      [
        fmt(d, 0),
        fmt(vol, 3),
        fmt(u, 1),
      ].forEach((cell, i) => {
        const td = document.createElement('td');
        td.style.cssText = 'padding:8px 10px;font-weight:' + (i === 1 ? '700;color:#60a5fa' : '600;color:rgba(255,255,255,.75)');
        td.innerHTML = cell;
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
  }

  /* ── SYRINGE CANVAS VISUALIZER ── */
  function drawSyringe(canvasId, fillPct, syringe) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const ctx    = canvas.getContext('2d');
    const W      = canvas.width;
    const H      = canvas.height;
    ctx.clearRect(0, 0, W, H);

    const pct    = Math.min(Math.max(fillPct / 100, 0), 1);
    const bx     = 20;   // barrel start x
    const bw     = 200;  // barrel width
    const by     = 20;   // barrel top y
    const bh     = 28;   // barrel height
    const fillW  = pct * bw;

    // Background barrel
    ctx.fillStyle = '#f1f5f9';
    ctx.beginPath();
    ctx.roundRect(bx, by, bw, bh, 4);
    ctx.fill();

    // Fill
    if (fillW > 0) {
      ctx.fillStyle = '#2563eb';
      ctx.beginPath();
      ctx.roundRect(bx, by, fillW, bh, 4);
      ctx.fill();
    }

    // Border
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth   = 1.5;
    ctx.beginPath();
    ctx.roundRect(bx, by, bw, bh, 4);
    ctx.stroke();

    // Needle
    ctx.strokeStyle = '#64748b';
    ctx.lineWidth   = 2;
    ctx.beginPath();
    ctx.moveTo(bx + bw, by + bh / 2);
    ctx.lineTo(bx + bw + 40, by + bh / 2);
    ctx.stroke();

    // Plunger
    ctx.fillStyle   = '#64748b';
    ctx.beginPath();
    ctx.roundRect(bx - 16, by - 4, 16, bh + 8, 3);
    ctx.fill();

    // Volume label
    ctx.fillStyle   = pct > 0.5 ? '#fff' : '#0f172a';
    ctx.font        = 'bold 11px Montserrat, sans-serif';
    ctx.textAlign   = 'center';
    ctx.textBaseline= 'middle';
    const label     = fmt(pct * (syringe === 50 ? 0.5 : 1), 3) + ' mL';
    ctx.fillText(label, bx + bw / 2, by + bh / 2);

    // Tick marks
    const ticks = 9;
    ctx.strokeStyle = 'rgba(100,116,139,.4)';
    ctx.lineWidth   = 1;
    for (let i = 1; i < ticks; i++) {
      const tx = bx + (bw / ticks) * i;
      ctx.beginPath();
      ctx.moveTo(tx, by);
      ctx.lineTo(tx, by + (i % 5 === 0 ? bh : bh * 0.4));
      ctx.stroke();
    }
  }

  /* ────────────────────────────────────────────────────
     REVERSE BAC CALCULATOR
  ──────────────────────────────────────────────────── */
  const rbBtn = document.getElementById('rb-calc-btn');
  if (rbBtn) {
    rbBtn.addEventListener('click', calcReverse);
    ['rb-vial','rb-conc','rb-dose'].forEach((id) => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('keydown', (e) => { if (e.key === 'Enter') calcReverse(); });
    });
  }

  function calcReverse() {
    const vial  = parseFloat(v('rb-vial'));
    const conc  = parseFloat(v('rb-conc'));
    const dose  = parseFloat(v('rb-dose'));

    if (!vial || !conc) {
      showError('reverse', 'Please enter vial size and target concentration.');
      return;
    }

    const bacVol  = (vial * 1000) / conc;            // mL BAC water to add
    const doseVol = dose ? dose / conc : null;
    const units   = doseVol ? doseVol * 100 : null;
    const doses   = dose ? Math.floor((vial * 1000) / dose) : null;

    set('rb-bac-vol',  fmt(bacVol, 2) + '<span class="unit">mL</span>');
    set('rb-dose-vol', doseVol !== null ? fmt(doseVol, 3) + '<span class="unit">mL</span>' : '—');
    set('rb-units',    units !== null   ? fmt(units, 1)  + '<span class="unit">IU</span>'  : '—');
    set('rb-doses',    doses !== null   ? doses + '<span class="unit">doses</span>'         : '—');

    show('rb-results');
  }

  /* ────────────────────────────────────────────────────
     INTRANASAL CALCULATOR
  ──────────────────────────────────────────────────── */
  const nBtn = document.getElementById('n-calc-btn');
  if (nBtn) {
    nBtn.addEventListener('click', calcNasal);
    ['n-peptide','n-solution','n-dose','n-spray'].forEach((id) => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('keydown', (e) => { if (e.key === 'Enter') calcNasal(); });
    });
  }

  function calcNasal() {
    const peptide   = parseFloat(v('n-peptide'));
    const solution  = parseFloat(v('n-solution'));
    const dose      = parseFloat(v('n-dose'));
    const sprayVol  = parseFloat(v('n-spray')) || 0.1;

    if (!peptide || !solution || !dose) {
      showError('nasal', 'Please fill in all fields.');
      return;
    }

    const conc          = (peptide * 1000) / solution;       // mcg / mL
    const mcgPerSpray   = conc * sprayVol;
    const spraysPerDose = dose / mcgPerSpray;
    const totalSprays   = solution / sprayVol;
    const totalDoses    = totalSprays / spraysPerDose;

    set('n-sprays-dose',  fmt(spraysPerDose, 1) + '<span class="unit">sprays</span>');
    set('n-mcg-spray',    fmt(mcgPerSpray, 1) + '<span class="unit">mcg</span>');
    set('n-conc',         fmt(conc, 0) + '<span class="unit">mcg/mL</span>');
    set('n-total-doses',  fmt(totalDoses, 0) + '<span class="unit">doses</span>');

    show('n-results');
  }

  /* ── UTILITIES ── */
  function v(id)    { const el = document.getElementById(id); return el ? el.value : ''; }
  function set(id, html) { const el = document.getElementById(id); if (el) el.innerHTML = html; }
  function show(id) { const el = document.getElementById(id); if (el) el.style.display = 'block'; }

  function showError(mode, msg) {
    // Flash red border on empty inputs (brief UX hint)
    const inputs = document.querySelectorAll('#mode-' + mode + ' .calc-input');
    inputs.forEach((inp) => {
      if (!inp.value) {
        inp.style.borderColor = '#dc2626';
        setTimeout(() => { inp.style.borderColor = ''; }, 1800);
      }
    });
    console.warn('[GBL Calculator]', msg);
  }

  function fmt(num, dp) {
    if (isNaN(num) || !isFinite(num)) return '—';
    return dp === 0 ? Math.round(num).toLocaleString() : num.toFixed(dp);
  }

})();
