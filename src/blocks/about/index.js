import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import {
	INLINE,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import { withRoles } from '../shared/part-controls';
import metadata from './block.json';

const LIST_TEMPLATE = withRoles( [
	[ 'core/list', { className: 'bwex-checks' } ],
] );

// Links must not navigate while editing.
const stop = ( event ) => event.preventDefault();

/**
 * Wrapper with the site's Elementor classes (same as render.php).
 *
 * @param {Object} props
 * @param {string} props.id        Elementor element ID.
 * @param {string} props.className Other classes.
 * @param {Object} props.children  Content.
 */
const W = ( { id, className, children } ) => (
	<div
		className={ `wp-block-group elementor-element elementor-element-${ id } ${ className }` }
	>
		{ children }
	</div>
);

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const {
		eyebrow,
		showEyebrow,
		title,
		lead,
		more = [],
		cardTitle,
		btnText,
		btnUrl,
		btnNewTab,
	} = attributes;
	const setMore = ( i, value ) =>
		setAttributes( {
			more: more.map( ( p, j ) => ( j === i ? value : p ) ),
		} );
	const blockProps = useBlockProps( {
		className: [ 'wp-block-group', attributes.classes, look.className ]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined,
	} );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex bwex-checksw' },
		{ allowedBlocks: [ 'core/list' ], template: LIST_TEMPLATE }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'More text', 'bestwebexpert' ) }>
					<p style={ { marginTop: 0 } }>
						{ __(
							'Paragraphs under the lead (phones show them behind "Read more").',
							'bestwebexpert'
						) }
					</p>
					{ more.map( ( p, i ) => (
						<div
							key={ i }
							style={ {
								display: 'flex',
								gap: 8,
								alignItems: 'center',
								marginBottom: 6,
							} }
						>
							<span
								style={ {
									flex: 1,
									overflow: 'hidden',
									whiteSpace: 'nowrap',
									textOverflow: 'ellipsis',
								} }
							>
								{ i + 1 }.{ ' ' }
								{ p.replace( /<[^>]+>/g, '' ) ||
									__( '(empty)', 'bestwebexpert' ) }
							</span>
							<Button
								variant="tertiary"
								isDestructive
								size="small"
								onClick={ () =>
									setAttributes( {
										more: more.filter(
											( _, j ) => j !== i
										),
									} )
								}
							>
								{ __( 'Remove', 'bestwebexpert' ) }
							</Button>
						</div>
					) ) }
					<Button
						variant="secondary"
						onClick={ () =>
							setAttributes( { more: [ ...more, '' ] } )
						}
					>
						{ __( '+ Add paragraph', 'bestwebexpert' ) }
					</Button>
				</PanelBody>
				<PanelBody title={ __( 'Card button', 'bestwebexpert' ) }>
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
						label={ __( 'Open in a new tab', 'bestwebexpert' ) }
						checked={ btnNewTab }
						onChange={ set( 'btnNewTab' ) }
					/>
					<p style={ { marginBottom: 0, opacity: 0.75 } }>
						{ __(
							'Leave the button text empty for no button.',
							'bestwebexpert'
						) }
					</p>
				</PanelBody>
			</InspectorControls>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			></SectionSettings>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<W
					id="2f9aa12"
					className="e-con-full bwex-wrap e-flex e-con e-child"
				>
					<W
						id="44e1935"
						className="e-con-full bwex-about__grid e-flex e-con e-child"
					>
						<W
							id="929d0d7"
							className="e-con-full bwex-about__copy e-flex e-con e-child"
						>
							{ showEyebrow !== false && (
								<W
									id="5fa24d3"
									className="bwex-eyebrow elementor-widget elementor-widget-text-editor"
								>
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
								</W>
							) }
							<W
								id="e4e543b"
								className="bwex-h2 elementor-widget elementor-widget-heading"
							>
								<RichText
									tagName="h2"
									className="elementor-heading-title elementor-size-default"
									value={ title }
									onChange={ set( 'title' ) }
									placeholder={ __(
										'Heading (italic = highlight)',
										'bestwebexpert'
									) }
									allowedFormats={ [ 'core/italic' ] }
								/>
							</W>
							<W
								id="5d9fa0f"
								className="bwex-about__lead elementor-widget elementor-widget-text-editor"
							>
								<RichText
									tagName="p"
									className="wp-block-paragraph"
									value={ lead }
									onChange={ set( 'lead' ) }
									placeholder={ __(
										'Lead: who you are, in two or three lines.',
										'bestwebexpert'
									) }
									allowedFormats={ INLINE }
								/>
							</W>
							{ more.length > 0 && (
								<W
									id="b6a1f79"
									className="bwex-about__more elementor-widget elementor-widget-bwex-read-more"
								>
									<div className="wp-block-group bwex bwex-readmorew">
										{ more.map( ( p, i ) => (
											<RichText
												key={ i }
												tagName="p"
												className="bwex-about__text wp-block-paragraph"
												value={ p }
												onChange={ ( v ) =>
													setMore( i, v )
												}
												placeholder={ __(
													'More text…',
													'bestwebexpert'
												) }
												allowedFormats={ INLINE }
											/>
										) ) }
									</div>
								</W>
							) }
						</W>
						<W
							id="90925e9"
							className="e-con-full bwex-about__card e-flex e-con e-child"
						>
							<W
								id="5ea19df"
								className="bwex-h3 elementor-widget elementor-widget-heading"
							>
								<RichText
									tagName="h3"
									className="elementor-heading-title elementor-size-default"
									value={ cardTitle }
									onChange={ set( 'cardTitle' ) }
									placeholder={ __(
										'Card title (optional)',
										'bestwebexpert'
									) }
									allowedFormats={ [] }
									disableLineBreaks
								/>
							</W>
							<div { ...listProps } />
							<div className="elementor-element elementor-element-46d77b3 bwex-btn bwex-btn--fill elementor-widget elementor-widget-button">
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
												'Button text (optional)',
												'bestwebexpert'
											) }
											allowedFormats={ [] }
											disableLineBreaks
										/>
									</span>
								</a>
							</div>
						</W>
					</W>
				</W>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
