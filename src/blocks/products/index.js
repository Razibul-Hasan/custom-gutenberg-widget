import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	AttrToggle,
	INLINE,
	HeadWidget,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
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
	const cardsProps = useInnerBlocksProps(
		{
			className:
				'wp-block-group elementor-element elementor-element-923a8b6 e-con-full bwex-cards e-flex e-con e-child',
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
