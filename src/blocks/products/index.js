import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import {
	AttrToggle,
	INLINE,
	HeadWidget,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import {
	PhoneLayoutPanel,
	SliderNav,
	sliderListProps,
} from '../shared/phone-slider';
import metadata from './block.json';

const TEMPLATE = [
	[ 'bwe/product-card', { art: 'reels' } ],
	[ 'bwe/product-card', { art: 'boxes' } ],
	[ 'bwe/product-card', { art: 'lift' } ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element elementor-element-d09262e e-con-full bwex-section bwex-section--soft bwex-work e-flex e-con e-child',
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined, // the site's #id rules (eyebrow icon …)
	} );
	const slider = sliderListProps( attributes );
	const cardCount = useSelect(
		( select ) => select( 'core/block-editor' ).getBlockCount( clientId ),
		[ clientId ]
	);
	const cardsProps = useInnerBlocksProps(
		{
			className: [
				'wp-block-group elementor-element elementor-element-923a8b6 e-con-full bwex-cards e-flex e-con e-child',
				slider.className,
			]
				.filter( Boolean )
				.join( ' ' ),
			style: slider.style,
		},
		{
			allowedBlocks: [ 'bwe/product-card' ],
			template: TEMPLATE,
			orientation: 'horizontal',
		}
	);
	return (
		<>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			>
				<AttrToggle
					label={ __(
						'Show the line under the cards',
						'bestwebexpert'
					) }
					name="showMore"
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
			</SectionSettings>
			<PhoneLayoutPanel
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-element elementor-element-bf148e3 e-con-full bwex-wrap e-flex e-con e-child">
					<HeadWidget
						attributes={ attributes }
						setAttributes={ setAttributes }
						elementId="addf4f8"
					/>
					<div { ...cardsProps } />
					<SliderNav attributes={ attributes } count={ cardCount } />
					{ attributes.showMore !== false && (
						<div className="wp-block-group elementor-element elementor-element-6fc4e95 bwex-more elementor-widget elementor-widget-text-editor">
							<RichText
								tagName="p"
								className="wp-block-paragraph"
								value={ attributes.more }
								onChange={ ( more ) =>
									setAttributes( { more } )
								}
								placeholder={ __(
									'Line under the cards (add a link)',
									'bestwebexpert'
								) }
								allowedFormats={ INLINE }
							/>
						</div>
					) }
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
