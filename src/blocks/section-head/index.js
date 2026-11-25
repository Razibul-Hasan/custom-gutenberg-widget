import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import metadata from './block.json';

function Edit( { attributes, setAttributes, isSelected } ) {
	const { eyebrow, title, headingId, intro, split } = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section header', 'bestwebexpert' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Intro beside the heading',
							'bestwebexpert'
						) }
						help={ __(
							'Off: the intro goes under the heading.',
							'bestwebexpert'
						) }
						checked={ !! split }
						onChange={ set( 'split' ) }
					/>
					<TextControl
						__nextHasNoMarginBottom
						label={ __(
							'Heading ID (for links, optional)',
							'bestwebexpert'
						) }
						value={ headingId }
						onChange={ set( 'headingId' ) }
					/>
				</PanelBody>
			</InspectorControls>
			{ /* Same nested divs as on the site, so the site's styles lay it out the same way. */ }
			<div
				{ ...useBlockProps( {
					className: 'wp-block-group bwex bwex-headw',
				} ) }
			>
				<div
					className={
						split
							? 'wp-block-group bwex-head bwex-head--split'
							: 'wp-block-group bwex-head'
					}
				>
					<div className="wp-block-group bwex-head__main">
						<div className="wp-block-group bwex-eyebrow">
							<RichText
								tagName="p"
								value={ eyebrow }
								onChange={ set( 'eyebrow' ) }
								placeholder={ __( 'Small label', 'bestwebexpert' ) }
								allowedFormats={ [] }
								disableLineBreaks
							/>
						</div>
						<div className="wp-block-group bwex-h2">
							<RichText
								tagName="h2"
								className="elementor-heading-title"
								id={ headingId || undefined }
								value={ title }
								onChange={ set( 'title' ) }
								placeholder={ __(
									'Heading — make words italic for the lime highlight',
									'bestwebexpert'
								) }
								allowedFormats={ [
									'core/italic',
									'core/link',
								] }
							/>
						</div>
					</div>
					{ ( intro || isSelected ) && (
						<div className="wp-block-group bwex-intro">
							<RichText
								tagName="p"
								value={ intro }
								onChange={ set( 'intro' ) }
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
					) }
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
