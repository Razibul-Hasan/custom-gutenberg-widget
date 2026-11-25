/**
 * Editor twin of includes/style-engine.php: CSS for a block's style settings (block.json "bweStyleMap",
 * values in the "bweStyle" attribute). Keep both in step.
 */
const MEDIA = {
	desktop: '@media (min-width:1025px)',
	tablet: '@media (max-width:1024px)',
	mobile: '@media (max-width:781px)',
};

export function cleanStyleValue( value ) {
	if ( typeof value === 'boolean' ) {
		return value ? 'true' : '';
	}
	if ( value === undefined || value === null ) {
		return '';
	}
	return String( value )
		.replace( /[<>{};\\"\r\n]/g, '' )
		.trim();
}

export function styleCss( map, values, className ) {
	const scope = `html body .${ className }:not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)`;
	const groups = {};
	( map || [] ).forEach( ( setting ) => {
		const value = cleanStyleValue( ( values || {} )[ setting.key ] );
		if ( value === '' ) {
			return;
		}
		setting.rules.forEach( ( rule ) => {
			let cssValue;
			if ( rule.fixed !== undefined ) {
				cssValue = rule.fixed;
			} else if ( rule.valueMap ) {
				if ( rule.valueMap[ value ] === undefined ) {
					return;
				}
				cssValue = rule.valueMap[ value ];
			} else {
				cssValue = ( rule.tpl || '{v}' ).split( '{v}' ).join( value );
			}
			const media = rule.media || '';
			const sel = rule.sel || '';
			groups[ media ] = groups[ media ] || {};
			groups[ media ][ sel ] = groups[ media ][ sel ] || [];
			groups[ media ][ sel ].push(
				`${ rule.prop }:${ cssValue }!important`
			);
		} );
	} );
	return Object.keys( groups )
		.map( ( media ) => {
			const block = Object.keys( groups[ media ] )
				.map(
					( sel ) =>
						`${ scope }${ sel }{${ groups[ media ][ sel ].join( ';' ) }}`
				)
				.join( '' );
			return media ? `${ MEDIA[ media ] }{${ block }}` : block;
		} )
		.join( '' );
}
