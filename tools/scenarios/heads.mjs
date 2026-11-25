// Editor scenario for bwe/section-head: every header renders its eyebrow, heading and (when set) intro, and every
// eyebrow still gets its section icon (::before background image) like on the site.
export default async ( { inCanvas } ) => {
	const r = await inCanvas( `const heads = [...d.querySelectorAll('[data-type="bwe/section-head"]')];
		const noIcon = heads.filter((h) => { const p = h.querySelector('.bwex-eyebrow p'); return !p || !W.getComputedStyle(p, '::before').backgroundImage.startsWith('url'); }).map((h) => h.querySelector('.bwex-eyebrow p')?.textContent);
		const noTitle = heads.filter((h) => !h.querySelector('h2.elementor-heading-title')?.textContent.trim()).length;
		return { heads: heads.length, noIcon, noTitle };` );
	return { ok: !! r && r.heads > 0 && ! r.noIcon.length && ! r.noTitle, ...r };
};
