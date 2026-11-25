/**
 * Home's hero and services patterns put three wrapper groups around the block (the old Elementor widget
 * wrapper), and the site's CSS for those sections is scoped to them. Inside Home's pattern the wrappers are
 * real group blocks; a block placed straight on a page has none, so it draws them itself — in the editor here,
 * on the site in includes/page-mode.php (bwe_gw_outer_wrap()). Keep the two lists in step.
 */
import { useSelect } from '@wordpress/data';

export const OUTER_WRAPS = {
	'bwe/hero': {
		marker: 'bwex-hero-scope',
		outer: 'elementor-element elementor-element-1876638 elementor-widget elementor-widget-bwex-hero',
		inner: 'bwe-home bwex bwex-hero-scope',
	},
	'bwe/services': {
		marker: 'bwex-svcw',
		outer: 'elementor-element elementor-element-be895a2 elementor-widget elementor-widget-bwex-services',
		inner: 'bwex bwex-svcw',
	},
};

/**
 * Whether the block must draw its own wrappers (its parent is not Home's wrapper group).
 *
 * @param {string} name     Block name.
 * @param {string} clientId Block client ID.
 * @return {boolean} Draw the wrappers.
 */
export function useOwnWrap( name, clientId ) {
	const marker = OUTER_WRAPS[ name ]?.marker;
	return useSelect(
		( select ) => {
			if ( ! marker ) {
				return false;
			}
			const store = select( 'core/block-editor' );
			const parent = store.getBlockRootClientId( clientId );
			const cls = parent
				? String( store.getBlockAttributes( parent )?.className || '' )
				: '';
			return ! cls.split( /\s+/ ).includes( marker );
		},
		[ marker, clientId ]
	);
}

/**
 * The wrapper groups around the section (when the block draws them).
 *
 * @param {Object} props
 * @param {string} props.name       Block name.
 * @param {Object} props.blockProps Props of the outermost element (useBlockProps).
 * @param {Object} props.children   The section.
 */
export function OuterWrap( { name, blockProps, children } ) {
	const wrap = OUTER_WRAPS[ name ];
	return (
		<div { ...blockProps }>
			<div className="wp-block-group elementor-widget-container">
				<div className={ 'wp-block-group ' + wrap.inner }>
					{ children }
				</div>
			</div>
		</div>
	);
}

/**
 * The section on its own, or inside the wrappers it draws.
 *
 * @param {Object}  props
 * @param {boolean} props.own        Draw the wrappers.
 * @param {string}  props.name       Block name.
 * @param {Object}  props.blockProps Props of the outermost element.
 * @param {Object}  props.children   The section.
 */
export function OuterWrapIf( { own, name, blockProps, children } ) {
	return own ? (
		<OuterWrap name={ name } blockProps={ blockProps }>
			{ children }
		</OuterWrap>
	) : (
		children
	);
}
