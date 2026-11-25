import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
import {
	AttrToggle,
	INLINE,
	HeadWidget,
	SectionHead,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import metadata from './block.json';

const TEMPLATE = [
	[ 'bwe/spec-card', { name: 'Speed' } ],
	[ 'bwe/spec-card', { name: 'Mobile-first design' } ],
	[ 'bwe/spec-card', { name: 'SEO foundations' } ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const soft = attributes.tone !== 'white';
	const head = (
		<SectionHead
			attributes={ attributes }
			setAttributes={ setAttributes }
			headw={ false }
		/>
	);
	const foot = attributes.showAside !== false && (
		<div className="wp-block-group bwex-spec__foot">
			<RichText
				tagName="p"
				className="bwex-spec__aside wp-block-paragraph"
				value={ attributes.aside }
				onChange={ ( aside ) => setAttributes( { aside } ) }
				placeholder={ __(
					'Line under the cards (add a link)',
					'bestwebexpert'
				) }
				allowedFormats={ INLINE }
			/>
		</div>
	);
	const look = useSectionLook( metadata, attributes, clientId );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-list bwex-spec__list' },
		{ allowedBlocks: [ 'bwe/spec-card' ], template: TEMPLATE }
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
					name="showAside"
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
				<SelectControl
					__nextHasNoMarginBottom
					__next40pxDefaultSize
					label={ __( 'Background', 'bestwebexpert' ) }
					value={ attributes.tone === 'white' ? 'white' : 'soft' }
					options={ [
						{
							label: __( 'Soft (light beige)', 'bestwebexpert' ),
							value: 'soft',
						},
						{
							label: __( 'White', 'bestwebexpert' ),
							value: 'white',
						},
					] }
					onChange={ ( tone ) => setAttributes( { tone } ) }
				/>
			</SectionSettings>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div
				{ ...useBlockProps( {
					className:
						'wp-block-group elementor-element elementor-element-ce6cb54 elementor-widget elementor-widget-bwex-spec',
				} ) }
			>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-widget-container">
					<div
						className={
							'wp-block-group bwex bwex-specw' +
							( soft ? ' bwex-specw--soft' : '' )
						}
					>
						<section
							className={ [
								'wp-block-group bwex-section bwex-spec' +
									( soft ? ' bwex-section--soft' : '' ),
								look.className,
							]
								.filter( Boolean )
								.join( ' ' ) }
							data-bwe-anchor={
								attributes.sectionId || undefined
							}
						>
							<div className="wp-block-group bwex-wrap">
								{ attributes.headWrap ? (
									<HeadWidget
										attributes={ attributes }
										setAttributes={ setAttributes }
									/>
								) : (
									head
								) }
								<div className="wp-block-group bwex-spec__body">
									<ul { ...listProps } />
									{ attributes.headWrap && foot }
								</div>
								{ ! attributes.headWrap && foot }
							</div>
						</section>
					</div>
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
