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
import metadata from './block.json';

const LIST_TEMPLATE = [ [ 'bwe/price-list' ] ];

// Links must not navigate while editing.
const stop = ( event ) => event.preventDefault();

function Edit( { attributes, setAttributes, clientId } ) {
	const {
		wrapClasses,
		cardId,
		chip,
		title,
		titleUrl,
		text,
		price,
		btnText,
		btnUrl,
		btnNewTab,
		bweStyle,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		bweStyle,
		clientId
	);
	const blockProps = useBlockProps( {
		className: [ 'wp-block-group', wrapClasses, className ]
			.filter( Boolean )
			.join( ' ' ),
	} );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex-plat__list' },
		{
			allowedBlocks: [ 'bwe/price-list' ],
			template: LIST_TEMPLATE,
		}
	);
	const titleField = (
		<RichText
			tagName="span"
			value={ title }
			onChange={ set( 'title' ) }
			placeholder={ __( 'Card title', 'bestwebexpert' ) }
			allowedFormats={ [ 'core/italic' ] }
			disableLineBreaks
		/>
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Links', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Title link (empty = no link)',
							'bestwebexpert'
						) }
						value={ titleUrl }
						onChange={ set( 'titleUrl' ) }
					/>
					<div style={ { height: 12 } } />
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button link', 'bestwebexpert' ) }
						value={ btnUrl }
						onChange={ set( 'btnUrl' ) }
					/>
					<div style={ { height: 12 } } />
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Open the button link in a new tab',
							'bestwebexpert'
						) }
						checked={ btnNewTab }
						onChange={ set( 'btnNewTab' ) }
					/>
					<div style={ { height: 12 } } />
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Card ID (for links like #wordpress-prices)',
							'bestwebexpert'
						) }
						help={ __(
							'Other pages link straight to this card with it. Leave empty for none.',
							'bestwebexpert'
						) }
						value={ cardId }
						onChange={ set( 'cardId' ) }
					/>
				</PanelBody>{ ' ' }
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div { ...blockProps }>
				{ css && <style>{ css }</style> }
				<div className="wp-block-group elementor-widget-container">
					<div className="wp-block-group bwex bwex-platw">
						<div className="wp-block-group bwex-plat bwe-prx__card">
							<div className="wp-block-group bwex-plat__chipwrap">
								<RichText
									tagName="p"
									className="bwex-plat__chip wp-block-paragraph"
									value={ chip }
									onChange={ set( 'chip' ) }
									placeholder={ __(
										'Chip, e.g. WordPress',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
							</div>
							<div className="wp-block-group bwex-h3">
								<h3 className="elementor-heading-title">
									{ titleUrl ? (
										<a href={ titleUrl } onClick={ stop }>
											{ titleField }
										</a>
									) : (
										titleField
									) }
								</h3>
							</div>
							<div className="wp-block-group bwex-plat__text">
								<RichText
									tagName="p"
									className="wp-block-paragraph"
									value={ text }
									onChange={ set( 'text' ) }
									placeholder={ __(
										'One or two lines about these services.',
										'bestwebexpert'
									) }
									allowedFormats={ [
										'core/bold',
										'core/italic',
										'core/link',
									] }
								/>
							</div>
							<div { ...listProps } />
							<div className="wp-block-group bwex-plat__foot">
								<RichText
									tagName="p"
									className="bwex-plat__price wp-block-paragraph"
									value={ price }
									onChange={ set( 'price' ) }
									placeholder={ __(
										'Websites from $250 (make the amount bold)',
										'bestwebexpert'
									) }
									allowedFormats={ [ 'core/bold' ] }
									disableLineBreaks
								/>
								<div className="bwex-btn">
									<a
										className="elementor-button elementor-button-link elementor-size-sm"
										href={ btnUrl || '#' }
										onClick={ stop }
									>
										<span className="elementor-button-content-wrapper">
											<RichText
												tagName="span"
												className="elementor-button-text"
												value={ btnText }
												onChange={ set( 'btnText' ) }
												placeholder={ __(
													'Button text',
													'bestwebexpert'
												) }
												allowedFormats={ [] }
												disableLineBreaks
											/>
										</span>
									</a>
								</div>
							</div>
						</div>
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
