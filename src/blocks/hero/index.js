import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import { OUTER_WRAPS, OuterWrapIf, useOwnWrap } from '../shared/outer-wrap';
import { ItemsPanel } from '../shared/section-parts';
import metadata from './block.json';

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const {
		kicker,
		btn1NewTab,
		btn2NewTab,
		jumpLinks,
		facts,
		title,
		lead,
		btn1Text,
		btn1Url,
		btn2Text,
		btn2Url,
		showBtn2,
		scrollText,
		scrollUrl,
		showScroll,
		modifiers,
		animate,
		animSpeed,
		animDelay,
		bweStyle,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		bweStyle,
		clientId
	);
	// Same section markup as on the site (without the animation's pre-hide flag: the script doesn't run here).
	// Straight on a page (not inside Home's wrapper groups) the block draws those wrappers itself.
	const ownWrap = useOwnWrap( metadata.name, clientId );
	const sectionProps = {
		className: [ 'wp-block-group', modifiers, className ]
			.filter( Boolean )
			.join( ' ' ),
	};
	const blockProps = useBlockProps(
		ownWrap
			? {
					className:
						'wp-block-group ' + OUTER_WRAPS[ metadata.name ].outer,
				}
			: sectionProps
	);
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Buttons & links', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Main button link', 'bestwebexpert' ) }
						value={ btn1Url }
						onChange={ set( 'btn1Url' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Open the main button in a new tab',
							'bestwebexpert'
						) }
						checked={ !! btn1NewTab }
						onChange={ set( 'btn1NewTab' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Show second button', 'bestwebexpert' ) }
						checked={ showBtn2 }
						onChange={ set( 'showBtn2' ) }
					/>
					{ showBtn2 && (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __(
								'Second button link',
								'bestwebexpert'
							) }
							value={ btn2Url }
							onChange={ set( 'btn2Url' ) }
						/>
					) }
					{ showBtn2 && (
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __(
								'Open the second button in a new tab',
								'bestwebexpert'
							) }
							checked={ !! btn2NewTab }
							onChange={ set( 'btn2NewTab' ) }
						/>
					) }
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Show the scroll-down arrow', 'bestwebexpert' ) }
						checked={ showScroll }
						onChange={ set( 'showScroll' ) }
					/>
					{ showScroll && (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ __( 'Scroll-down arrow goes to',
								'bestwebexpert'
							) }
							help={ __(
								'e.g. #services (the ID of the next section)',
								'bestwebexpert'
							) }
							value={ scrollUrl }
							onChange={ set( 'scrollUrl' ) }
						/>
					) }
				</PanelBody>
				<ItemsPanel
					title={ __(
						'Jump links (numbered, under the buttons)',
						'bestwebexpert'
					) }
					items={ jumpLinks }
					fields={ [
						{ key: 'label', label: __( 'Label', 'bestwebexpert' ) },
						{
							key: 'url',
							label: __(
								'Goes to (e.g. #pricing)',
								'bestwebexpert'
							),
						},
					] }
					blank={ { label: '', url: '#' } }
					addLabel={ __( '+ Add a jump link', 'bestwebexpert' ) }
					onChange={ set( 'jumpLinks' ) }
				/>
				<ItemsPanel
					title={ __(
						'Facts line (short facts under the buttons)',
						'bestwebexpert'
					) }
					items={ facts }
					fields={ [
						{
							key: 'text',
							label: __(
								'Fact (e.g. 10 looks)',
								'bestwebexpert'
							),
						},
					] }
					blank={ { text: '' } }
					addLabel={ __( '+ Add a fact', 'bestwebexpert' ) }
					onChange={ set( 'facts' ) }
				/>
				<PanelBody
					title={ __( 'Entrance animation', 'bestwebexpert' ) }
					initialOpen={ false }
				>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Animate on page load', 'bestwebexpert' ) }
						checked={ animate }
						onChange={ set( 'animate' ) }
					/>
					{ animate && (
						<>
							<RangeControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __(
									'Speed (1 = normal, higher = faster)',
									'bestwebexpert'
								) }
								value={ animSpeed }
								min={ 0.5 }
								max={ 2 }
								step={ 0.05 }
								onChange={ ( v ) =>
									setAttributes( { animSpeed: v ?? 1 } )
								}
							/>
							<RangeControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __(
									'Delay (seconds)',
									'bestwebexpert'
								) }
								value={ animDelay }
								min={ 0 }
								max={ 2 }
								step={ 0.1 }
								onChange={ ( v ) =>
									setAttributes( { animDelay: v ?? 0 } )
								}
							/>
						</>
					) }
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
					<div className="wp-block-group bwe-hero__copy">
						{ ( kicker || isSelected ) && (
							<RichText
								tagName="p"
								className="bwe-kicker wp-block-paragraph"
								value={ kicker }
								onChange={ set( 'kicker' ) }
								placeholder={ __(
									'Kicker line above the heading (optional)',
									'bestwebexpert'
								) }
								allowedFormats={ [
									'core/bold',
									'core/italic',
								] }
								disableLineBreaks
							/>
						) }
						<RichText
							tagName="h1"
							className="wp-block-heading elementor-heading-title bwe-hero__title"
							value={ title }
							onChange={ set( 'title' ) }
							placeholder={ __(
								'Hero heading — make words italic to highlight them',
								'bestwebexpert'
							) }
							allowedFormats={ [ 'core/italic' ] }
						/>
						<RichText
							tagName="p"
							className="bwe-lead wp-block-paragraph"
							value={ lead }
							onChange={ set( 'lead' ) }
							placeholder={ __(
								'A short line under the heading',
								'bestwebexpert'
							) }
							allowedFormats={ [
								'core/bold',
								'core/italic',
								'core/link',
							] }
						/>
						<div className="wp-block-buttons bwe-actions is-layout-flex wp-block-buttons-is-layout-flex">
							<div className="wp-block-button bwe-btn bwe-btn--primary">
								<RichText
									tagName="div"
									className="wp-block-button__link wp-element-button"
									value={ btn1Text }
									onChange={ set( 'btn1Text' ) }
									placeholder={ __(
										'Main button',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
							</div>
							{ showBtn2 && (
								<div className="wp-block-button bwe-btn bwex-hero__link bwex-hero__btn2">
									<RichText
										tagName="div"
										className="wp-block-button__link wp-element-button"
										value={ btn2Text }
										onChange={ set( 'btn2Text' ) }
										placeholder={ __(
											'Second button',
											'bestwebexpert'
										) }
										allowedFormats={ [] }
										disableLineBreaks
									/>
								</div>
							) }
						</div>
						{ Array.isArray( facts ) &&
							facts.some( ( f ) => f && f.text ) && (
								<p className="bwex-hero__meta wp-block-paragraph">
									{ facts
										.filter( ( f ) => f && f.text )
										.map( ( f, i ) => (
											<span key={ i }>{ f.text }</span>
										) ) }
								</p>
							) }
						{ Array.isArray( jumpLinks ) &&
							jumpLinks.some( ( l ) => l && l.label ) && (
								<p className="bwex-jump wp-block-paragraph">
									{ jumpLinks
										.filter( ( l ) => l && l.label )
										.map( ( l, i ) => (
											<a
												key={ i }
												href={ l.url || '#' }
												onClick={ ( e ) =>
													e.preventDefault()
												}
											>
												<span>
													{ String( i + 1 ).padStart(
														2,
														'0'
													) }
												</span>
												{ l.label }
											</a>
										) ) }
								</p>
							) }
					</div>
					{ showScroll && (
						<div className="bwex-scroll-wrap">
							<a
								className="bwex-scroll"
								href={ scrollUrl || '#' }
								onClick={ ( event ) => event.preventDefault() }
							>
								<RichText
									tagName="span"
									value={ scrollText }
									onChange={ set( 'scrollText' ) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
								<i aria-hidden="true"></i>
							</a>
						</div>
					) }
				</section>
			</OuterWrapIf>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
