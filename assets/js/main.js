/* Pastor Adewale theme: vanilla JS, no dependencies. */
(function () {
	'use strict';
	var L = (window.PA && window.PA.labels) || {};
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

	/* ---------- toast ---------- */
	var toastTimer;
	function toast(msg) {
		var el = $('#toast');
		if (!el) { return; }
		el.textContent = msg;
		el.classList.add('show');
		clearTimeout(toastTimer);
		toastTimer = setTimeout(function () { el.classList.remove('show'); }, 3500);
	}

	/* ---------- header: solid after scroll ---------- */
	var header = $('#siteHeader');
	function onScroll() { if (header) { header.classList.toggle('stuck', window.scrollY > 40); } }
	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();

	/* ---------- full-screen menu ---------- */
	var menu = $('#menu'), menuBtn = $('#menuBtn'), lastFocus = null;
	function openMenu() {
		if (!menu) { return; }
		lastFocus = document.activeElement;
		menu.hidden = false;
		menu.classList.add('open');
		menuBtn.setAttribute('aria-expanded', 'true');
		document.body.style.overflow = 'hidden';
		var c = $('#menuClose'); if (c) { c.focus(); }
	}
	function closeMenu() {
		if (!menu || !menu.classList.contains('open')) { return; }
		menu.classList.remove('open');
		menu.hidden = true;
		menuBtn.setAttribute('aria-expanded', 'false');
		document.body.style.overflow = '';
		if (lastFocus && lastFocus.focus) { lastFocus.focus(); }
	}
	if (menuBtn) { menuBtn.addEventListener('click', openMenu); }
	var mc = $('#menuClose'); if (mc) { mc.addEventListener('click', closeMenu); }
	if (menu) { menu.addEventListener('click', function (e) { if (e.target.closest('a')) { closeMenu(); } }); }

	/* ---------- modals ---------- */
	function openModal(id) {
		var m = document.getElementById(id);
		if (!m) { return; }
		if (id === 'shareModal') { prepShare(); }
		m.hidden = false;
		m.classList.add('open');
		var f = $('input,button', m); if (f && id !== 'shareModal') { f.focus(); }
	}
	function closeModals() {
		$$('.modal.open').forEach(function (m) { m.classList.remove('open'); m.hidden = true; });
	}
	document.addEventListener('click', function (e) {
		var o = e.target.closest('[data-open]');
		if (o) { e.preventDefault(); openModal(o.getAttribute('data-open')); return; }
		var m = e.target.closest('.modal');
		if (m && (e.target === m || e.target.closest('[data-close]'))) { closeModals(); return; }
		var s = e.target.closest('[data-scroll]');
		if (s) { var t = $(s.getAttribute('data-scroll')); if (t) { t.scrollIntoView({ behavior: 'smooth', block: 'start' }); } }
		var f = e.target.closest('[data-focus]');
		if (f) {
			var on = document.body.classList.toggle('watch-focus');
			f.textContent = on ? L.exitFocus : L.focus;
		}
	});
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeModals(); closeMenu(); } });

	/* ---------- share ---------- */
	function prepShare() {
		var u = location.href, e = encodeURIComponent(u), t = encodeURIComponent(document.title);
		var set = function (id, v) { var el = document.getElementById(id); if (el) { el.href = v; } };
		set('sFb', 'https://www.facebook.com/sharer/sharer.php?u=' + e);
		set('sX', 'https://twitter.com/intent/tweet?url=' + e + '&text=' + t);
		set('sTg', 'https://t.me/share/url?url=' + e + '&text=' + t);
		set('sWa', 'https://wa.me/?text=' + t + '%20' + e);
		var l = $('#shareLink'); if (l) { l.value = u; }
	}
	var cp = $('#copyBtn');
	if (cp) {
		cp.addEventListener('click', function () {
			var i = $('#shareLink'); i.select();
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(i.value).then(function () { toast(L.copied); }, function () { toast(L.copyHint); });
			} else { try { document.execCommand('copy'); toast(L.copied); } catch (x) { toast(L.copyHint); } }
		});
	}

	/* ---------- live search suggestions (WordPress REST search) ---------- */
	var gs = $('#gSearch'), gr = $('#gResults'), st;
	if (gs && gr && window.PA) {
		gs.addEventListener('input', function () {
			clearTimeout(st);
			var q = gs.value.trim();
			if (q.length < 2) { gr.textContent = ''; return; }
			st = setTimeout(function () {
				fetch(PA.rest + '?search=' + encodeURIComponent(q) + '&per_page=8&_fields=title,url,subtype')
					.then(function (r) { return r.ok ? r.json() : []; })
					.then(function (items) {
						gr.textContent = '';
						if (!items.length) { var p = document.createElement('p'); p.style.cssText = 'color:var(--muted);padding:10px 4px'; p.textContent = L.noResults; gr.appendChild(p); return; }
						items.forEach(function (it) {
							var a = document.createElement('a'), s = document.createElement('span'), k = document.createElement('small');
							a.href = it.url; s.textContent = it.title; k.textContent = (it.subtype || '').replace('_', ' ');
							a.appendChild(s); a.appendChild(k); gr.appendChild(a);
						});
					})
					.catch(function () { gr.textContent = ''; });
			}, 250);
		});
	}

	/* ---------- library filters ---------- */
	$$('select[data-autosubmit]').forEach(function (s) { s.addEventListener('change', function () { s.form.submit(); }); });

	/* ---------- hero carousel ---------- */
	var hero = $('#hero');
	if (hero) {
		var vs = $$('.vslide', hero), ts = $$('.tslide', hero), ds = $$('.dots button', hero), i = 0, timer;
		var go = function (n) {
			i = (n + vs.length) % vs.length;
			vs.forEach(function (x, k) { x.classList.toggle('on', k === i); x.setAttribute('aria-hidden', k === i ? 'false' : 'true'); });
			ts.forEach(function (x, k) { x.classList.toggle('on', k === i); });
			ds.forEach(function (x, k) { x.setAttribute('aria-current', k === i ? 'true' : 'false'); });
		};
		var stop = function () { clearInterval(timer); };
		var start = function () {
			stop();
			if (vs.length < 2 || (window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches)) { return; }
			timer = setInterval(function () { go(i + 1); }, 6500);
		};
		ds.forEach(function (b, k) { b.addEventListener('click', function () { go(k); start(); }); });
		hero.addEventListener('mouseenter', stop); hero.addEventListener('mouseleave', start);
		hero.addEventListener('focusin', stop); hero.addEventListener('focusout', start);
		var sx = null;
		hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
		hero.addEventListener('touchend', function (e) {
			if (sx === null) { return; }
			var dx = e.changedTouches[0].clientX - sx;
			if (Math.abs(dx) > 50) { go(i + (dx < 0 ? 1 : -1)); start(); }
			sx = null;
		});
		start();
	}

	/* ---------- continue watching (stored only in the visitor's own browser) ---------- */
	var wd = $('#watchData');
	if (wd) {
		try {
			localStorage.setItem('paLast', JSON.stringify({
				id: wd.dataset.id, title: wd.dataset.title, url: wd.dataset.url,
				series: wd.dataset.series, lesson: wd.dataset.lesson, total: wd.dataset.total, tone: wd.dataset.tone
			}));
		} catch (e) { /* storage blocked: ignore */ }
	}
	var cw = $('#contWatch');
	if (cw) {
		var last = null;
		try { last = JSON.parse(localStorage.getItem('paLast') || 'null'); } catch (e) { last = null; }
		if (last && last.url && /^https?:\/\//.test(last.url) && last.url.indexOf(location.origin) === 0) {
			var box = $('.cw', cw), a = document.createElement('a');
			a.className = 'cw-card'; a.href = last.url;
			var th = document.createElement('span'); th.className = 'thumb t' + (parseInt(last.tone, 10) || 1);
			var sy = document.createElement('span'); sy.className = 'sym'; sy.textContent = '▶'; th.appendChild(sy);
			var d = document.createElement('div'), r = document.createElement('span'), h = document.createElement('h3'), p = document.createElement('p');
			r.className = 'rmeta'; r.textContent = L.continue; h.textContent = last.title;
			p.textContent = last.series ? last.series + ' · ' + L.lesson + ' ' + last.lesson + ' ' + L.of + ' ' + last.total : '';
			d.appendChild(r); d.appendChild(h); d.appendChild(p);
			var bt = document.createElement('span'); bt.className = 'btn btn-primary'; bt.textContent = L.resume;
			a.appendChild(th); a.appendChild(d); a.appendChild(bt);
			box.appendChild(a); cw.hidden = false;
		}
	}

	/* ---------- contents bar built from the page headings ---------- */
	var toc = $('#pageToc'), content = $('.entry-content');
	if (toc && content) {
		var hs = $$('h2', content);
		if (hs.length > 1) {
			var inner = $('.wrap', toc);
			hs.forEach(function (h, k) {
				if (!h.id) { h.id = 'sec-' + (k + 1) + '-' + h.textContent.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''); }
				var a = document.createElement('a'); a.href = '#' + h.id; a.textContent = h.textContent; inner.appendChild(a);
			});
			toc.hidden = false;
		}
	}

	/* ---------- giving (Paystack inline, confirmed on the server) ---------- */
	var gf = $('#giveForm');
	if (gf && window.PA_GIVE) {
		var G = window.PA_GIVE, amt = 0, method = $('#m-card') ? 'card' : 'bank';
		var custom = $('#customAmt'), cta = $('#giveCta'), msg = $('#giveMsg'), name = $('#giveName'), email = $('#giveEmail');
		var fmt = function (n) { return '₦' + Number(n).toLocaleString('en-NG'); };
		var upd = function () { if (cta) { $('span', cta).textContent = amt >= 100 ? 'Give ' + fmt(amt) : 'Give'; } };
		var pressed = $('#amts button[aria-pressed="true"]'); if (pressed) { amt = Number(pressed.dataset.v); }
		var seg = function (id, cb) {
			$$('#' + id + ' button').forEach(function (b) {
				b.addEventListener('click', function () {
					$$('#' + id + ' button').forEach(function (x) { x.setAttribute('aria-pressed', 'false'); });
					b.setAttribute('aria-pressed', 'true'); cb(b.dataset.v);
				});
			});
		};
		seg('amts', function (v) { amt = Number(v); custom.value = ''; upd(); });
		seg('pay', function (v) {
			method = v;
			var c = $('#m-card'), b = $('#m-bank');
			if (c) { c.classList.toggle('show', v === 'card'); }
			if (b) { b.classList.toggle('show', v === 'bank'); }
			if (cta) { cta.hidden = v === 'bank'; }
		});
		custom.addEventListener('input', function () {
			amt = Number(custom.value) || 0;
			$$('#amts button').forEach(function (x) { x.setAttribute('aria-pressed', 'false'); });
			upd();
		});
		upd();
		gf.addEventListener('submit', function (e) {
			e.preventDefault();
			if (method !== 'card' || !G.key) { return; }
			var nm = name.value.trim(), em = email.value.trim();
			if (!nm || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(em) || amt < 100) { msg.textContent = G.invalid; return; }
			if (typeof window.PaystackPop === 'undefined') { msg.textContent = G.failed; return; }
			var ref = 'PA' + Date.now() + Math.floor(Math.random() * 1e6);
			var handler = window.PaystackPop.setup({
				key: G.key, email: em, amount: Math.round(amt * 100), currency: G.currency, ref: ref,
				metadata: { custom_fields: [{ display_name: 'Donor name', variable_name: 'donor_name', value: nm }] },
				callback: function (res) {
					msg.textContent = G.pending;
					var fd = new FormData();
					fd.append('action', 'pa_verify_donation'); fd.append('nonce', G.nonce);
					fd.append('reference', res.reference); fd.append('name', nm);
					fetch(G.ajax, { method: 'POST', body: fd, credentials: 'same-origin' })
						.then(function (r) { return r.json(); })
						.then(function (j) { msg.textContent = j && j.success ? G.thanks : G.failed; })
						.catch(function () { msg.textContent = G.failed; });
				},
				onClose: function () { if (!/^Confirm|^Thank/.test(msg.textContent)) { msg.textContent = G.closed; } }
			});
			handler.openIframe();
		});
	}
})();
