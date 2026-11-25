import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import { RawHTML, useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import {
	INLINE,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import metadata from './block.json';

const FORMS = window.bweGw?.cf7Forms || [];

/**
 * The chosen form as the site shows it (REST preview; Contact Form 7 shortcodes only).
 *
 * @param {Object} props
 * @param {string} props.form Shortcode.
 */
function FormPreview( { form } ) {
	const [ html, setHtml ] = useState( '' );
	useEffect( () => {
		let live = true;
		setHtml( '' );
		if ( form ) {
			apiFetch( {
				path: addQueryArgs( '/bwe-gw/v1/form-preview', { form } ),
			} )
				.then( ( r ) => live && setHtml( r?.html || '' ) )
				.catch( () => live && setHtml( '' ) );
		}
		return () => {
			live = false;
		};
	}, [ form ] );
	if ( ! form ) {
		return (
			<p style={ { padding: 24, opacity: 0.7 } }>
				{ __(
					'Pick a form in the sidebar (Form panel).',
					'bestwebexpert'
				) }
			</p>
		);
	}
	// Inert: a preview to look at, not a form to send from the editor.
	// Contact Form 7's own stylesheet isn't in the editor: hide its hidden-fields box and empty message box.
	return html ? (
		<div
			inert=""
			className="bwe-gw-form-preview"
			style={ { pointerEvents: 'none' } }
		>
			<style>
				{
					'.bwe-gw-form-preview :is(.hidden-fields-container, .wpcf7-response-output, .screen-reader-response){display:none!important}'
				}
			</style>
			<RawHTML>{ html }</RawHTML>
		</div>
	) : (
		<p style={ { padding: 24 } }>{ form }</p>
	);
}

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { eyebrow, showEyebrow, title, intro, note, form } = attributes;
	const known = FORMS.some( ( f ) => f.shortcode === form );
	const sectionClass = [
		'wp-block-group',
		attributes.classes,
		look.className,
	]
		.filter( Boolean )
		.join( ' ' );
	// The block's own element is the outermost one: the .bwe-wfu wrapper when it is on, else the section.
	const blockProps = useBlockProps(
		attributes.scope
			? { className: 'wp-block-group bwe-wfu' }
			: {
					className: sectionClass,
					'data-bwe-anchor': attributes.sectionId || undefined,
				}
	);
	const sectionProps = attributes.scope
		? {
				className: sectionClass,
				'data-bwe-anchor': attributes.sectionId || undefined,
			}
		: blockProps;
	const section = (
		<section { ...sectionProps }>
			{ look.css && <style>{ look.css }</style> }
			<div className="wp-block-group bwex-wrap">
				<div className="wp-block-group bwex-wfu-form__grid">
					<div className="wp-block-group bwex-wfu-form__aside">
						{ showEyebrow !== false && (
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
						) }
						<div className="wp-block-group bwex-h2">
							<RichText
								tagName="h2"
								className="elementor-heading-title"
								value={ title }
								onChange={ set( 'title' ) }
								placeholder={ __(
									'Heading (italic = highlight)',
									'bestwebexpert'
								) }
								allowedFormats={ [ 'core/italic' ] }
							/>
						</div>
						<div className="wp-block-group bwex-intro">
							<RichText
								tagName="p"
								className="wp-block-paragraph"
								value={ intro }
								onChange={ set( 'intro' ) }
								placeholder={ __(
									'Intro: what happens after they send it.',
									'bestwebexpert'
								) }
								allowedFormats={ INLINE }
							/>
							<RichText
								tagName="p"
								className="wp-block-paragraph"
								value={ note }
								onChange={ set( 'note' ) }
								placeholder={ __(
									'Second line, e.g. other ways to reach you (optional)',
									'bestwebexpert'
								) }
								allowedFormats={ INLINE }
							/>
						</div>
					</div>
					<div
						className={
							'wp-block-group ' + ( attributes.cardClasses || '' )
						}
					>
						<FormPreview form={ form } />
					</div>
				</div>
			</div>
		</section>
	);
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Form', 'bestwebexpert' ) }>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Contact Form 7 form', 'bestwebexpert' ) }
						value={ known ? form : '' }
						options={ [
							{
								label: FORMS.length
									? __( '— Choose a form —', 'bestwebexpert' )
									: __(
											'No Contact Form 7 forms found',
											'bestwebexpert'
										),
								value: '',
							},
							...FORMS.map( ( f ) => ( {
								label: f.title,
								value: f.shortcode,
							} ) ),
						] }
						onChange={ ( v ) => v && setAttributes( { form: v } ) }
						help={ __(
							'Edit the form fields in Contact → Contact Forms.',
							'bestwebexpert'
						) }
					/>
					<div style={ { height: 12 } } />
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Or a form shortcode', 'bestwebexpert' ) }
						value={ form }
						onChange={ set( 'form' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			>
				<ToggleControl
					__nextHasNoMarginBottom
					label={ __( 'Add the form styles (turn off on Contact and Write for Us: those pages add them)',
						'bestwebexpert'
					) }
					checked={ !! attributes.scope }
					onChange={ set( 'scope' ) }
				/>
			</SectionSettings>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			{ attributes.scope ? (
				<div { ...blockProps }>{ section }</div>
			) : (
				section
			) }
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
