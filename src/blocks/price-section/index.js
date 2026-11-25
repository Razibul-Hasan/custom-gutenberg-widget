import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	HeadWidget,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import { useSelect } from '@wordpress/data';
import metadata from './block.json';

// Used only when the block has no cards yet (the inserter starter fills it with the WordPress + Shopify cards).
const TEMPLATE = [
	[ 'bwe/price-card', {}, [ [ 'bwe/price-list' ] ] ],
	[ 'bwe/price-card', {}, [ [ 'bwe/price-list' ] ] ],
];

/**
 * Cards-per-row classes, as bwe_gw_price_section_layout() (includes/price-section.php) prints them.
 *
 * @param {Object} style Styles-tab values.
 * @param {number} cards Number of cards.
 * @return {string} '' = the site's own two-card layout.
 */
function layoutClasses( style, cards ) {
	const pick = ( key, max ) => {
		const n = parseInt( style?.[ key ], 10 );
		return n >= 1 && n <= max ? n : 0;
	};
	let d = pick( 'columns', 3 );
	let t = pick( 'columnsTablet', 3 );
	let m = pick( 'columnsMobile', 2 );
	if ( cards === 2 && ! d && ! t && ! m ) {
		return '';
	}
	const n = Math.max( 1, cards );
	d = d || ( n === 4 ? 2 : Math.min( 3, n ) );
	t = t || Math.min( 2, n );
	m = m || 1;
	return `bwe-ps--even bwe-ps--d${ d } bwe-ps--t${ t } bwe-ps--m${ m }`;
}

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const cards = useSelect(
		( select ) => select( 'core/block-editor' ).getBlockCount( clientId ),
		[ clientId ]
	);
	const layout = layoutClasses( attributes.bweStyle, cards );
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element elementor-element-0334ad8 e-con-full bwex-section bwex-services bwe-prx__prices e-flex e-con e-child',
			attributes.classes,
			layout,
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined, // the site's #id rules (eyebrow icon …)
	} );
	const cardsProps = useInnerBlocksProps(
		{
			className:
				'wp-block-group elementor-element elementor-element-1de90ac e-con-full bwex-plats bwe-prx__plats e-flex e-con e-child',
		},
		{
			allowedBlocks: [ 'bwe/price-card' ],
			template: TEMPLATE,
			orientation: 'horizontal',
		}
	);
	return (
		<>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ layout && window.bweGw?.priceSectionCss && (
					<style>{ window.bweGw.priceSectionCss }</style>
				) }
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-element elementor-element-b51609b e-con-full bwex-wrap e-flex e-con e-child">
					<HeadWidget
						attributes={ attributes }
						setAttributes={ setAttributes }
						elementId="b43b5f9"
					/>
					<div { ...cardsProps } />
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
