import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import { OUTER_WRAPS, OuterWrapIf, useOwnWrap } from '../shared/outer-wrap';
import metadata from './block.json';

const TEMPLATE = [
	[ 'bwe/service-tile' ],
	[ 'bwe/service-tile' ],
	[ 'bwe/service-tile' ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const {
		eyebrow,
		title,
		lead,
		more,
		showMore,
		sectionId,
		modifiers,
		bweStyle,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		bweStyle,
		clientId
	);
	// Straight on a page (not inside Home's wrapper groups) the block draws those wrappers itself.
	const ownWrap = useOwnWrap( metadata.name, clientId );
	const sectionProps = {
		className: [ 'wp-block-group', modifiers, className ]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': sectionId || undefined,
	};
	const blockProps = useBlockProps(
		ownWrap
			? {
					className:
						'wp-block-group ' + OUTER_WRAPS[ metadata.name ].outer,
				}
			: sectionProps
	);
	const gridProps = useInnerBlocksProps(
		{ className: 'wp-block-list bwex-svc__grid' },
		{
			allowedBlocks: [ 'bwe/service-tile' ],
			template: TEMPLATE,
			orientation: 'horizontal',
		}
	);
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Section ID (for links like #services)',
							'bestwebexpert'
						) }
						value={ sectionId }
						onChange={ set( 'sectionId' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Show the line under the tiles',
							'bestwebexpert'
						) }
						checked={ showMore }
						onChange={ set( 'showMore' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<OuterWrapIf
				own={ ownWrap }
				name={ metadata.name }
				blockProps={ blockProps }
			>
				<section { ...( ownWrap ? sectionProps : blockProps ) }>
					{ css && <style>{ css }</style> }
					<div className="wp-block-group bwex-wrap">
						<div className="wp-block-group bwex-svc">
							<div className="wp-block-group bwex-svc__head">
								<div className="wp-block-group bwex-h2 bwex-svc__title">
									<div className="wp-block-group bwex-eyebrow">
										<RichText
											tagName="p"
											className="wp-block-paragraph"
											value={ eyebrow }
											onChange={ set( 'eyebrow' ) }
											placeholder={ __( 'Small label',
												'bestwebexpert'
											) }
											allowedFormats={ [] }
											disableLineBreaks
										/>
									</div>
									<RichText
										tagName="h2"
										className="elementor-heading-title"
										value={ title }
										onChange={ set( 'title' ) }
										placeholder={ __(
											'Heading — make words italic to highlight them',
											'bestwebexpert'
										) }
										allowedFormats={ [ 'core/italic' ] }
									/>
								</div>
								<div className="wp-block-group bwex-svc__lead">
									<RichText
										tagName="p"
										className="wp-block-paragraph"
										value={ lead }
										onChange={ set( 'lead' ) }
										placeholder={ __(
											'Intro (optional)',
											'bestwebexpert'
										) }
										allowedFormats={ [
											'core/bold',
											'core/italic',
											'core/link',
										] }
									/>
								</div>
							</div>
							<div className="wp-block-group bwex-svc__body">
								<ul { ...gridProps } />
							</div>
							{ showMore && (
								<RichText
									tagName="p"
									className="bwex-more wp-block-paragraph"
									value={ more }
									onChange={ set( 'more' ) }
									placeholder={ __(
										'Line under the tiles (add a link)',
										'bestwebexpert'
									) }
									allowedFormats={ [
										'core/bold',
										'core/italic',
										'core/link',
									] }
								/>
							) }
						</div>
					</div>
				</section>
			</OuterWrapIf>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
