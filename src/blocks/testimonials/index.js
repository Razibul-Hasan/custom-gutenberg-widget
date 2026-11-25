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
	[ 'bwe/video-card' ],
	[ 'bwe/video-card' ],
	[ 'bwe/video-card' ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element elementor-element-fdfb384 e-con-full bwex-section bwex-section--dark bwex-proof e-flex e-con e-child',
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined, // the site's #id rules (eyebrow icon …)
	} );
	const cardCount = useSelect(
		( select ) => select( 'core/block-editor' ).getBlockCount( clientId ),
		[ clientId ]
	);
	const slider = sliderListProps( attributes, cardCount );
	const quotesProps = useInnerBlocksProps(
		{
			className: [
				'wp-block-group bwex-quotes',
				attributes.phoneLayout !== 'slider' && 'bwex-quotes--list',
				slider.className,
			]
				.filter( Boolean )
				.join( ' ' ),
			style: slider.style,
		},
		{
			allowedBlocks: [ 'bwe/video-card' ],
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
						'Show the review links line',
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
				itemName={ __( 'video', 'bestwebexpert' ) }
				desktop
			/>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-element elementor-element-68c7412 e-con-full bwex-wrap e-flex e-con e-child">
					<HeadWidget
						attributes={ attributes }
						setAttributes={ setAttributes }
						elementId="a63a1b2"
					/>
					<div className="wp-block-group elementor-element elementor-element-ace3f83 elementor-widget elementor-widget-bwex-proof">
						<div className="wp-block-group elementor-widget-container">
							<div className="wp-block-group bwex bwex-proofw">
								<div { ...quotesProps } />
								<SliderNav
									attributes={ attributes }
									count={ cardCount }
								/>
								{ attributes.showMore !== false && (
									<RichText
										tagName="p"
										className="bwex-more wp-block-paragraph"
										value={ attributes.more }
										onChange={ ( more ) =>
											setAttributes( { more } )
										}
										placeholder={ __(
											'Line under the videos (add review links)',
											'bestwebexpert'
										) }
										allowedFormats={ INLINE }
									/>
								) }
							</div>
						</div>
					</div>
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
