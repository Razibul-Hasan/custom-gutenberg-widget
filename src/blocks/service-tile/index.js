import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import IconPanel from '../shared/icon-control';
import { iconCss } from '../shared/icon-engine';
import metadata from './block.json';

// Icons drawn by the site CSS (.bwex-svc__item--<icon>).
const ICONS = [
	[ 'wordpress', 'WordPress' ],
	[ 'woocommerce', 'WooCommerce' ],
	[ 'gutenberg', 'Blocks (Gutenberg)' ],
	[ 'theme', 'Theme' ],
	[ 'apps', 'Apps' ],
	[ 'speed', 'Speed' ],
	[ 'ai-seo', 'AI SEO' ],
	[ 'redesign', 'Redesign' ],
	[ 'maintenance', 'Maintenance' ],
	[ 'shopify', 'Shopify' ],
	[ 'webdev', 'Web development' ],
	[ 'appreview', 'App review' ],
].map( ( [ value, label ] ) => ( { value, label } ) );

const PLATFORMS = [
	{ value: 'wp', label: 'WordPress' },
	{ value: 'shopify', label: 'Shopify' },
	{ value: 'both', label: 'Both' },
];

// Where the tile's icon is drawn (the site CSS puts it on .bwex-svc__top::before).
const ICON_PART = ' .bwex-svc__top::before';

function Edit( { attributes, setAttributes, clientId } ) {
	const { icon, platform, url, tag, name, desc, bweIcon } = attributes;
	const custom = iconCss( bweIcon, ICON_PART, clientId, '#c8ff3d' );
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Service tile', 'bestwebexpert' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Link', 'bestwebexpert' ) }
						value={ url }
						onChange={ set( 'url' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Site icon', 'bestwebexpert' ) }
						help={ __(
							'Used while “Icon” below is set to Site icon.',
							'bestwebexpert'
						) }
						value={ icon }
						options={ ICONS }
						onChange={ set( 'icon' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Platform colours', 'bestwebexpert' ) }
						value={ platform }
						options={ PLATFORMS }
						onChange={ set( 'platform' ) }
					/>
				</PanelBody>
				<IconPanel
					title={ __( 'Icon', 'bestwebexpert' ) }
					value={ bweIcon }
					onChange={ set( 'bweIcon' ) }
					defaultColor="#c8ff3d"
					chip="#1f2414"
				/>
			</InspectorControls>
			<li
				{ ...useBlockProps( {
					className: [
						'bwex-svc__item',
						`bwex-svc__item--${ icon }`,
						custom.className,
					]
						.filter( Boolean )
						.join( ' ' ),
				} ) }
			>
				{ custom.css && <style>{ custom.css }</style> }
				{ /* Same <a> as on the site so the tile styles apply; it must not navigate while editing. */ }
				<a
					className={ `bwex-svc__tile bwex-svc__tile--${ platform }` }
					href={ url || '#' }
					onClick={ ( event ) => event.preventDefault() }
				>
					<span className="bwex-svc__top">
						<RichText
							tagName="span"
							className="bwex-svc__tag"
							value={ tag }
							onChange={ set( 'tag' ) }
							placeholder={ __( 'Tag', 'bestwebexpert' ) }
							allowedFormats={ [] }
							disableLineBreaks
						/>
					</span>
					<RichText
						tagName="strong"
						className="bwex-svc__name"
						value={ name }
						onChange={ set( 'name' ) }
						placeholder={ __( 'Service name', 'bestwebexpert' ) }
						allowedFormats={ [] }
						disableLineBreaks
					/>
					<RichText
						tagName="span"
						className="bwex-svc__desc"
						value={ desc }
						onChange={ set( 'desc' ) }
						placeholder={ __(
							'One line about the service.',
							'bestwebexpert'
						) }
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>
					<span className="bwex-svc__arrow" aria-hidden="true">
						→
					</span>
				</a>
			</li>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
