/**
 * Editor twin of includes/icons.php: turns a block's "bweIcon" attribute into the CSS that draws it on the
 * site's own icon spot (a ::before / ::after). Keep both in step.
 */
const COLOR =
	/^(#[0-9a-fA-F]{3,8}|rgba?\([0-9.,\s%]+\)|hsla?\([0-9.,\s%deg]+\)|[a-zA-Z]{3,20})$/;
const SIZE = /^\d{1,3}(\.\d+)?(px|rem|em|%)$/;

export function iconColor( color ) {
	const c = String( color || '' ).trim();
	return COLOR.test( c ) ? c : '';
}

export function iconSvg( icon, defaultColor = '#c8ff3d' ) {
	if ( ! icon ) {
		return '';
	}
	const color = iconColor( icon.color );
	if ( icon.source === 'library' && icon.svg ) {
		return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="${
			color || defaultColor
		}" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">${ icon.svg }</svg>`;
	}
	if ( icon.source === 'svg' && /<svg\b/i.test( icon.svg || '' ) ) {
		let svg = icon.svg;
		if ( ! /<svg\b[^>]*\bxmlns=/i.test( svg ) ) {
			svg = svg.replace(
				/<svg\b/i,
				'<svg xmlns="http://www.w3.org/2000/svg"'
			);
		}
		return color ? svg.replace( /currentColor/gi, color ) : svg;
	}
	return '';
}

export function iconUrl( icon, defaultColor ) {
	if ( ! icon ) {
		return '';
	}
	if ( icon.source === 'upload' ) {
		return icon.url
			? `url("${ String( icon.url ).replace( /["\\\n\r<>]/g, encodeURIComponent ) }")`
			: '';
	}
	const svg = iconSvg( icon, defaultColor );
	return svg
		? `url("data:image/svg+xml,${ encodeURIComponent( svg ) }")`
		: '';
}

/**
 * Scope class + CSS for a custom icon ('' / '' when the block keeps the site's icon).
 *
 * @param {Object} icon         The bweIcon attribute.
 * @param {string} part         Selector of the icon spot inside the block, e.g. ' .bwex-svc__top::before'.
 * @param {string} clientId     Block client ID (for the editor scope class).
 * @param {string} defaultColor Line colour of library icons when none is picked.
 * @return {{className: string, css: string}} Scope class and CSS.
 */
export function iconCss( icon, part, clientId, defaultColor ) {
	if ( ! icon || ! icon.source ) {
		return { className: '', css: '' };
	}
	const decls = [];
	if ( icon.source === 'none' ) {
		decls.push( 'display:none!important' );
	} else {
		const url = iconUrl( icon, defaultColor );
		if ( ! url ) {
			return { className: '', css: '' };
		}
		decls.push( `background-image:${ url }!important` );
		if ( SIZE.test( icon.size || '' ) ) {
			decls.push(
				`background-size:${ icon.size } ${ icon.size }!important`
			);
		} else if ( icon.source === 'upload' ) {
			decls.push( 'background-size:contain!important' );
		}
		decls.push( 'background-repeat:no-repeat!important' );
		decls.push( 'background-position:center!important' );
	}
	const className = 'bwe-i-e' + clientId.replace( /-/g, '' ).slice( 0, 10 );
	return {
		className,
		css: `html body .${ className }:not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)${ part }{${ decls.join(
			';'
		) }}`,
	};
}
