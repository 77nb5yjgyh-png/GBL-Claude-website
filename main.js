/* ─────────────────────────────────────────────────────
   GBL Peptide Theme — main.js
───────────────────────────────────────────────────── */

(function () {
  'use strict';

  /* ── MOBILE MENU TOGGLE ── */
  const toggle   = document.getElementById('menu-toggle');
  const mobileNav = document.getElementById('mobile-nav');

  if (toggle && mobileNav) {
    toggle.addEventListener('click', () => {
      const open = toggle.classList.toggle('active');
      mobileNav.classList.toggle('open', open);
      toggle.setAttribute('aria-expanded', String(open));
      mobileNav.setAttribute('aria-hidden',  String(!open));
      document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!toggle.contains(e.target) && !mobileNav.contains(e.target)) {
        toggle.classList.remove('active');
        mobileNav.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        mobileNav.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        toggle.classList.remove('active');
        mobileNav.classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  }

  /* ── PRODUCT PAGE TABS ── */
  const tabBtns   = document.querySelectorAll('.tab-btn');
  const tabPanels = document.querySelectorAll('.tab-panel');

  if (tabBtns.length) {
    tabBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('aria-controls');

        tabBtns.forEach((b) => {
          b.classList.remove('active');
          b.setAttribute('aria-selected', 'false');
        });
        tabPanels.forEach((p) => p.classList.remove('active'));

        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');
        const target = document.getElementById(targetId);
        if (target) target.classList.add('active');
      });
    });
  }

  /* ── PRODUCT IMAGE GALLERY THUMBS ── */
  const thumbs   = document.querySelectorAll('.product-image-thumb');
  const mainImg  = document.querySelector('.product-image-main img');

  thumbs.forEach((thumb) => {
    thumb.addEventListener('click', () => {
      const src = thumb.dataset.src;
      if (mainImg && src) {
        mainImg.src = src;
      }
      thumbs.forEach((t) => t.classList.remove('active'));
      thumb.classList.add('active');
    });
  });

  /* ── PRODUCT OPTION BUTTONS ── */
  document.querySelectorAll('.option-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const group = btn.closest('.product-option-btns');
      if (group) {
        group.querySelectorAll('.option-btn').forEach((b) => b.classList.remove('active'));
      }
      btn.classList.add('active');
    });
  });

  /* ── QUANTITY BUTTONS ── */
  document.querySelectorAll('.qty-minus').forEach((btn) => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.qty-input-wrap').querySelector('.qty-input');
      const val   = parseInt(input.value, 10);
      if (val > parseInt(input.min || 1, 10)) input.value = val - 1;
    });
  });

  document.querySelectorAll('.qty-plus').forEach((btn) => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.qty-input-wrap').querySelector('.qty-input');
      const max   = parseInt(input.max || 99, 10);
      const val   = parseInt(input.value, 10);
      if (val < max) input.value = val + 1;
    });
  });

  /* ── MINI PRODUCT CALCULATOR ── */
  const mcBtn = document.getElementById('mc-calc-btn');
  if (mcBtn) {
    mcBtn.addEventListener('click', () => {
      const vial   = parseFloat(document.getElementById('mc-vial').value);
      const bac    = parseFloat(document.getElementById('mc-bac').value);
      const dose   = parseFloat(document.getElementById('mc-dose').value);

      if (!vial || !bac || !dose) {
        alert('Please fill in all three fields.');
        return;
      }

      const conc   = (vial * 1000) / bac;          // mcg/mL
      const vol    = dose / conc;                    // mL
      const units  = vol * 100;                      // IU (U-100)

      document.getElementById('mc-volume').innerHTML = fmt(vol, 3) + '<span class="unit">mL</span>';
      document.getElementById('mc-units').innerHTML  = fmt(units, 1) + '<span class="unit">IU</span>';
      document.getElementById('mc-conc').innerHTML   = fmt(conc, 0) + '<span class="unit">mcg/mL</span>';

      document.getElementById('mc-results').style.display = 'block';
    });
  }

  /* ── NEWSLETTER FORM ── */
  const nlForm = document.getElementById('newsletter-form');
  if (nlForm && typeof GBL !== 'undefined') {
    nlForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const email  = nlForm.querySelector('input[type="email"]').value;
      const msgEl  = document.getElementById('newsletter-msg');
      const btn    = nlForm.querySelector('button[type="submit"]');

      btn.disabled    = true;
      btn.textContent = 'Sending…';

      try {
        const data = new FormData();
        data.append('action', 'gbl_newsletter');
        data.append('email',  email);
        data.append('nonce',  GBL.nonce);

        const res  = await fetch(GBL.ajax_url, { method: 'POST', body: data });
        const json = await res.json();

        msgEl.style.display = 'block';
        msgEl.style.color   = json.success ? '#16a34a' : '#dc2626';
        msgEl.textContent   = json.data.message;

        if (json.success) nlForm.reset();
      } catch {
        msgEl.style.display = 'block';
        msgEl.style.color   = '#dc2626';
        msgEl.textContent   = 'Something went wrong. Please try again.';
      } finally {
        btn.disabled    = false;
        btn.textContent = 'Subscribe';
      }
    });
  }

  /* ── SMOOTH SCROLL (anchor links) ── */
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener('click', (e) => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ── UTILITY ── */
  function fmt(num, dp) {
    if (isNaN(num)) return '—';
    return dp === 0 ? Math.round(num).toLocaleString() : num.toFixed(dp);
  }

})();
