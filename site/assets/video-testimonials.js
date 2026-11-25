/* Video testimonials: load the YouTube player only when a thumbnail is clicked.
 * YouTube's own UI is off (controls=0) and the iframe is taller than the card, so its title bar and
 * logo sit in the cropped area. Our overlay button plays / pauses through the iframe JS API. */
(function () {
	var ORIGIN = 'https://www.youtube-nocookie.com';

	function cmd(frame, func) {
		frame.contentWindow.postMessage(JSON.stringify({ event: 'command', func: func, args: [] }), ORIGIN);
	}

	function start(btn) {
		var id = btn.getAttribute('data-yt');
		if (!/^[A-Za-z0-9_-]{11}$/.test(id)) {
			return;
		}
		var box = btn.parentNode;
		var f = document.createElement('iframe');
		f.src = ORIGIN + '/embed/' + id + '?autoplay=1&controls=0&disablekb=1&fs=0&iv_load_policy=3&modestbranding=1&playsinline=1&rel=0&enablejsapi=1&origin=' + encodeURIComponent(location.origin);
		f.title = btn.getAttribute('aria-label') || 'Client video testimonial';
		f.allow = 'autoplay; encrypted-media; picture-in-picture';
		f.className = 'bwex-yt__frame';
		f.tabIndex = -1;

		var ctl = document.createElement('button');
		ctl.type = 'button';
		ctl.className = 'bwex-yt__ctl';
		ctl.setAttribute('aria-label', 'Pause video');
		ctl.innerHTML = '<span class="bwex-yt__play" aria-hidden="true"></span>';

		box.classList.add('is-playing');
		btn.hidden = true;
		box.appendChild(f);
		box.appendChild(ctl);

		f.addEventListener('load', function () {
			f.contentWindow.postMessage(JSON.stringify({ event: 'listening', id: id }), ORIGIN);
		});

		ctl.addEventListener('click', function () {
			var playing = box.classList.contains('is-playing');
			cmd(f, playing ? 'pauseVideo' : 'playVideo');
			setState(box, ctl, !playing);
		});

		box._bwexReset = function () {
			f.remove();
			ctl.remove();
			box.classList.remove('is-playing', 'is-paused');
			btn.hidden = false;
		};
		box._bwexFrame = f;
		box._bwexCtl = ctl;
	}

	function setState(box, ctl, playing) {
		box.classList.toggle('is-playing', playing);
		box.classList.toggle('is-paused', !playing);
		ctl.setAttribute('aria-label', playing ? 'Pause video' : 'Play video');
	}

	document.addEventListener('click', function (e) {
		var btn = e.target.closest && e.target.closest('.bwex-yt[data-yt]');
		if (!btn) {
			return;
		}
		// pause any other playing testimonial
		document.querySelectorAll('.bwex-vt__video.is-playing').forEach(function (box) {
			if (box._bwexFrame) {
				cmd(box._bwexFrame, 'pauseVideo');
				setState(box, box._bwexCtl, false);
			}
		});
		start(btn);
	});

	// player state from the iframe: 0 ended, 1 playing, 2 paused
	window.addEventListener('message', function (e) {
		if (e.origin !== ORIGIN || typeof e.data !== 'string') {
			return;
		}
		var d;
		try { d = JSON.parse(e.data); } catch (err) { return; }
		var state = d && d.info && typeof d.info.playerState === 'number' ? d.info.playerState : null;
		if (null === state) {
			return;
		}
		document.querySelectorAll('.bwex-vt__video').forEach(function (box) {
			if (!box._bwexFrame || box._bwexFrame.contentWindow !== e.source) {
				return;
			}
			if (0 === state) {
				box._bwexReset();
			} else if (1 === state || 2 === state) {
				setState(box, box._bwexCtl, 1 === state);
			}
		});
	});
})();
