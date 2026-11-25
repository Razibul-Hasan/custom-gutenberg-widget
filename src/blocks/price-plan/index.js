import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import { AttrText } from '../shared/section-parts';
import { withRoles } from '../shared/part-controls';
import metadata from './block.json';

// The feature list is a normal List block: Enter adds a feature, Backspace on an empty one removes it.
const LIST = withRoles( [
	[
		'core/list',
		{ className: 'bwex-checks' },
		[
			[ 'core/list-item', { content: 'First feature' } ],
			[ 'core/list-item', { content: 'Second feature' } ],
			[ 'core/list-item', { content: 'Third feature' } ],
		],
	],
] );

function Edit( { attributes, setAttributes, clientId } ) {
	const { name, price, desc, featured, badge, btnText, btnStyle } =
		attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const primary =
		btnStyle === 'primary' || ( btnStyle === 'auto' && featured );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex-plan__list' },
		{ allowedBlocks: [ 'core/list' ], template: LIST }
	);
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Plan', 'bestwebexpert' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Featured plan (highlighted, with badge)',
							'bestwebexpert'
						) }
						checked={ !! featured }
						onChange={ set( 'featured' ) }
					/>
					<AttrText
						label={ __( 'Button link', 'bestwebexpert' ) }
						name="btnUrl"
						attributes={ attributes }
						setAttributes={ setAttributes }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Open the button in a new tab',
							'bestwebexpert'
						) }
						checked={ !! attributes.btnNewTab }
						onChange={ set( 'btnNewTab' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Button style', 'bestwebexpert' ) }
						value={ btnStyle }
						options={ [
							{
								label: __(
									'Automatic (filled on the featured plan)',
									'bestwebexpert'
								),
								value: 'auto',
							},
							{
								label: __( 'Filled', 'bestwebexpert' ),
								value: 'primary',
							},
							{
								label: __( 'Outline', 'bestwebexpert' ),
								value: 'outline',
							},
						] }
						onChange={ set( 'btnStyle' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div
				{ ...useBlockProps( {
					className: [
						'wp-block-group',
						attributes.wrapClasses,
						className,
					]
						.filter( Boolean )
						.join( ' ' ),
				} ) }
			>
				{ css && <style>{ css }</style> }
				<div className="wp-block-group elementor-widget-container">
					<div className="wp-block-group bwex bwex-planw">
						<div
							className={
								'wp-block-group bwex-plan' +
								( featured ? ' bwex-plan--featured' : '' )
							}
						>
							{ featured && (
								<div className="wp-block-group bwex-plan__badgewrap">
									<RichText
										tagName="p"
										className="bwex-plan__badge wp-block-paragraph"
										value={ badge }
										onChange={ set( 'badge' ) }
										placeholder={ __(
											'Badge',
											'bestwebexpert'
										) }
										allowedFormats={ [] }
										disableLineBreaks
									/>
								</div>
							) }
							<div className="wp-block-group bwex-h3">
								<RichText
									tagName="h3"
									className="elementor-heading-title"
									value={ name }
									onChange={ set( 'name' ) }
									placeholder={ __(
										'Plan name',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
							</div>
							<RichText
								tagName="p"
								className="bwex-plan__price wp-block-paragraph"
								value={ price }
								onChange={ set( 'price' ) }
								placeholder={ __(
									'$250 / project (italic = small text)',
									'bestwebexpert'
								) }
								allowedFormats={ [
									'core/italic',
									'core/bold',
								] }
								disableLineBreaks
							/>
							<RichText
								tagName="p"
								className="bwex-plan__desc wp-block-paragraph"
								value={ desc }
								onChange={ set( 'desc' ) }
								placeholder={ __(
									'Who this plan is for',
									'bestwebexpert'
								) }
								allowedFormats={ [
									'core/bold',
									'core/italic',
									'core/link',
								] }
							/>
							<div { ...listProps } />
							<div className="wp-block-buttons bwex-plan__btns is-layout-flex wp-block-buttons-is-layout-flex">
								<div
									className={
										'wp-block-button bwe-btn' +
										( primary ? ' bwe-btn--primary' : '' )
									}
								>
									<RichText
										tagName="div"
										className="wp-block-button__link wp-element-button"
										value={ btnText }
										onChange={ set( 'btnText' ) }
										placeholder={ __(
											'Button text',
											'bestwebexpert'
										) }
										allowedFormats={ [] }
										disableLineBreaks
									/>
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
