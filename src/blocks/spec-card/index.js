import { __, sprintf } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- the link picker core blocks use.
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import metadata from './block.json';

const FORMATS = [ 'core/bold', 'core/italic', 'core/link' ];

// Same rule as bwe_gw_spec_card_cover() (includes/blocks.php): the text's last link, when its words end in an arrow.
function textLink( text ) {
	const match =
		/<a\s[^>]*href=(["'])([^"']+)\1[^>]*>((?:(?!<\/a>)[\s\S])*)<\/a>\s*$/i.exec(
			text || ''
		);
	if ( ! match || match[ 2 ] === '#' ) {
		return '';
	}
	const words = match[ 3 ].replace( /<[^>]+>/g, '' ).trim();
	return /(?:→|↗|&rarr;|&#8594;)$/.test( words ) ? match[ 2 ] : '';
}

function Edit( { attributes, setAttributes, isSelected } ) {
	const { name, text, chip, clickable, url, newTab } = attributes;
	const nameHasLink = /<a\s/i.test( name || '' );
	const fromText = textLink( text );

	let help;
	if ( ! clickable ) {
		help = __(
			'Only the links inside the card can be clicked.',
			'bestwebexpert'
		);
	} else if ( nameHasLink ) {
		help = __(
			'The link in the card name already makes the whole card clickable.',
			'bestwebexpert'
		);
	} else if ( url ) {
		help = __( 'The whole card opens the link below.', 'bestwebexpert' );
	} else if ( fromText ) {
		help = sprintf(
			/* translators: %s: link address. */
			__(
				'The whole card opens the link at the end of the text: %s',
				'bestwebexpert'
			),
			fromText
		);
	} else {
		help = __(
			'Add a link below, or end the text with a link such as “Open the demo →”, to make the whole card clickable.',
			'bestwebexpert'
		);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Card link', 'bestwebexpert' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Whole card clickable', 'bestwebexpert' ) }
						help={ help }
						checked={ clickable }
						onChange={ ( value ) =>
							setAttributes( { clickable: value } )
						}
					/>
					{ clickable && ! nameHasLink && (
						<>
							<p
								className="components-base-control__label"
								style={ { marginTop: 16 } }
							>
								{ __(
									'Card link (optional)',
									'bestwebexpert'
								) }
							</p>
							{ LinkControl ? (
								<LinkControl
									value={ { url, opensInNewTab: newTab } }
									onChange={ ( next ) =>
										setAttributes( {
											url: next.url || '',
											newTab: !! next.opensInNewTab,
										} )
									}
									onRemove={ () =>
										setAttributes( {
											url: '',
											newTab: false,
										} )
									}
								/>
							) : (
								<>
									<TextControl
										__nextHasNoMarginBottom
										label={ __(
											'Link URL',
											'bestwebexpert'
										) }
										value={ url }
										onChange={ ( value ) =>
											setAttributes( { url: value } )
										}
									/>
									<ToggleControl
										__nextHasNoMarginBottom
										label={ __(
											'Open in a new tab',
											'bestwebexpert'
										) }
										checked={ newTab }
										onChange={ ( value ) =>
											setAttributes( { newTab: value } )
										}
									/>
								</>
							) }
						</>
					) }
				</PanelBody>
			</InspectorControls>
			<li { ...useBlockProps() }>
				<RichText
					tagName="strong"
					className="bwex-spec__name"
					value={ name }
					onChange={ ( value ) => setAttributes( { name: value } ) }
					placeholder={ __( 'Name', 'bestwebexpert' ) }
					allowedFormats={ FORMATS }
					disableLineBreaks
				/>
				<RichText
					tagName="span"
					className="bwex-spec__text"
					value={ text }
					onChange={ ( value ) => setAttributes( { text: value } ) }
					placeholder={ __(
						'One or two lines in plain words.',
						'bestwebexpert'
					) }
					allowedFormats={ FORMATS }
				/>
				{ /* The tag is optional: like on the site, it is only shown when it has text (or while editing the card). */ }
				{ ( chip || isSelected ) && (
					<RichText
						tagName="code"
						value={ chip }
						onChange={ ( value ) =>
							setAttributes( { chip: value } )
						}
						placeholder={ __( 'Tag (optional)', 'bestwebexpert' ) }
						allowedFormats={ [] }
						disableLineBreaks
					/>
				) }
			</li>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
