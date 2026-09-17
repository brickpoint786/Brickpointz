/**
 * BrickPoint frontend interactions.
 * Mobile menu, sticky header, WhatsApp float + order modal, filters, contact form.
 */
(function () {
  'use strict';

  /* Sticky header shadow */
  var header = document.querySelector('.bp-header');
  function onScroll() {
    if (!header) return;
    if (window.scrollY > 20) header.classList.add('is-scrolled');
    else header.classList.remove('is-scrolled');
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* Mobile menu */
  var toggle = document.querySelector('[data-bp-menu-toggle]');
  var menu = document.querySelector('[data-bp-mobile-menu]');
  if (toggle && menu) {
    toggle.addEventListener('click', function () {
      var open = menu.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.style.overflow = open ? 'hidden' : '';
      var iconOpen = toggle.querySelector('[data-icon-open]');
      var iconClose = toggle.querySelector('[data-icon-close]');
      if (iconOpen && iconClose) {
        iconOpen.style.display = open ? 'none' : '';
        iconClose.style.display = open ? '' : 'none';
      }
    });
    menu.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        menu.classList.remove('open');
        document.body.style.overflow = '';
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* WhatsApp float tooltip */
  var waBtn = document.querySelector('[data-bp-wa-toggle]');
  var waTip = document.querySelector('[data-bp-wa-tip]');
  if (waBtn && waTip) {
    waBtn.addEventListener('click', function () {
      waTip.classList.toggle('open');
    });
    var dismiss = waTip.querySelector('[data-bp-wa-dismiss]');
    if (dismiss) {
      dismiss.addEventListener('click', function (e) {
        e.stopPropagation();
        var wrap = document.querySelector('.bp-wa-float');
        if (wrap) wrap.style.display = 'none';
      });
    }
  }

  /* WhatsApp order modal */
  var modal = document.querySelector('[data-bp-modal]');
  var modalProduct = document.querySelector('[data-bp-modal-product]');
  var current = { product: '', category: '', price: '' };

  function openModal(product, category, price) {
    current = { product: product, category: category, price: price };
    if (modalProduct) modalProduct.textContent = product;
    ['bp-qty', 'bp-loc', 'bp-msg'].forEach(function (id) {
      var el = document.getElementById(id);
      if (el) el.value = '';
    });
    if (modal) {
      modal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
  }
  function closeModal() {
    if (modal) modal.classList.remove('open');
    document.body.style.overflow = '';
  }
  document.querySelectorAll('[data-bp-order]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      openModal(
        btn.getAttribute('data-product') || '',
        btn.getAttribute('data-category') || '',
        btn.getAttribute('data-price') || 'Price on Request'
      );
    });
  });
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal || e.target.closest('[data-bp-modal-close]')) closeModal();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeModal();
    });
    var send = modal.querySelector('[data-bp-modal-send]');
    if (send) {
      send.addEventListener('click', function () {
        var qty = (document.getElementById('bp-qty') || {}).value || '';
        var loc = (document.getElementById('bp-loc') || {}).value || '';
        var extra = (document.getElementById('bp-msg') || {}).value || '';
        var priceText = current.price === 'Price on Request' || !current.price
          ? 'Please share the latest price and availability.'
          : 'Price: ' + current.price;
        var msg = 'Assalam-o-Alaikum BrickPoint,\nI am interested in the following product:\n\nProduct: ' +
          current.product + '\nCategory: ' + current.category + '\n' + priceText;
        if (qty) msg += '\nQuantity: ' + qty;
        if (loc) msg += '\nDelivery Location: ' + loc;
        if (extra) msg += '\n\nAdditional Info: ' + extra;
        msg += '\n\nPlease share availability, delivery details, and final quotation.\nThank you.';
        var num = (window.brickpointData && window.brickpointData.whatsapp) || '923152850818';
        window.open('https://wa.me/' + num + '?text=' + encodeURIComponent(msg), '_blank');
        closeModal();
      });
    }
  }

  /* Project filters (client-side, mirrors original category pills) */
  var pills = document.querySelectorAll('[data-bp-filter]');
  var cards = document.querySelectorAll('[data-bp-project-cat]');
  if (pills.length && cards.length) {
    pills.forEach(function (pill) {
      pill.addEventListener('click', function () {
        pills.forEach(function (p) { p.classList.remove('active'); });
        pill.classList.add('active');
        var f = pill.getAttribute('data-bp-filter');
        cards.forEach(function (card) {
          var c = card.getAttribute('data-bp-project-cat');
          card.style.display = (f === 'All' || f === c) ? '' : 'none';
        });
      });
    });
  }

  /* Contact form (AJAX) */
  var form = document.querySelector('[data-bp-contact-form]');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var statusOk = form.parentElement.querySelector('[data-bp-form-success]');
      var statusErr = form.parentElement.querySelector('[data-bp-form-error]');
      var errText = form.parentElement.querySelector('[data-bp-form-error-text]');
      if (statusOk) statusOk.style.display = 'none';
      if (statusErr) statusErr.style.display = 'none';
      var fd = new FormData(form);
      var name = (fd.get('name') || '').toString().trim();
      var phone = (fd.get('phone') || '').toString().trim();
      var email = (fd.get('email') || '').toString().trim();
      if (!name || (!phone && !email)) {
        if (statusErr && errText) {
          errText.textContent = 'Please provide your name and at least a phone number or email.';
          statusErr.style.display = 'flex';
        }
        return;
      }
      fd.append('action', 'brickpoint_contact');
      fd.append('nonce', (window.brickpointData && window.brickpointData.contactNonce) || '');
      var btn = form.querySelector('[type="submit"]');
      var orig = btn ? btn.innerHTML : '';
      if (btn) { btn.disabled = true; btn.innerHTML = 'Sending...'; }
      fetch((window.brickpointData && window.brickpointData.ajaxUrl) || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: fd,
        credentials: 'same-origin'
      })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res && res.success) {
            if (statusOk) statusOk.style.display = 'flex';
            form.reset();
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
          } else {
            if (statusErr && errText) {
              errText.textContent = (res && res.data && res.data.message) || 'Something went wrong. Please try WhatsApp.';
              statusErr.style.display = 'flex';
            }
          }
        })
        .catch(function () {
          if (statusErr && errText) {
            errText.textContent = 'Connection error. Please try WhatsApp or call us directly.';
            statusErr.style.display = 'flex';
          }
        })
        .finally(function () {
          if (btn) { btn.disabled = false; btn.innerHTML = orig; }
        });
    });
  }

  /* Reveal on scroll */
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (en.isIntersecting) {
        en.target.classList.add('bp-animate-fade');
        io.unobserve(en.target);
      }
    });
  }, { threshold: 0.08 });
  document.querySelectorAll('[data-bp-reveal]').forEach(function (el) { io.observe(el); });
})();
