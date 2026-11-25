import { __, sprintf } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	Button,
	Flex,
	FlexBlock,
	PanelBody,
	SelectControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

// Keep in step with BWE_GW_BUTTON_LOOKS (includes/generic-blocks.php).
export const LOOKS = {
	primary: 'bwe-btn bwe-btn--primary',
	outline: 'bwe-btn',
	dark: 'bwe-btn bwe-gw-btn--dark',
	light: 'bwe-btn bwe-gw-btn--light',
	link: 'bwe-gw-btn--link',
};
const LOOK_OPTIONS = [
	{ label: __( 'Lime (main action)', 'bestwebexpert' ), value: 'primary' },
	{ label: __( 'Outline', 'bestwebexpert' ), value: 'outline' },
	{ label: __( 'Dark', 'bestwebexpert' ), value: 'dark' },
	{
		label: __( 'Light outline (on dark backgrounds)', 'bestwebexpert' ),
		value: 'light',
	},
	{ label: __( 'Text link (underlined)', 'bestwebexpert' ), value: 'link' },
];
const REL_OPTIONS = [
	{ label: __( 'Normal link', 'bestwebexpert' ), value: '' },
	{
		label: __( 'nofollow (don’t pass ranking)', 'bestwebexpert' ),
		value: 'nofollow',
	},
	{
		label: __( 'sponsored (paid / affiliate)', 'bestwebexpert' ),
		value: 'sponsored',
	},
	{ label: __( 'ugc (user content)', 'bestwebexpert' ), value: 'ugc' },
];
const ALIGN = [
	{ label: __( 'Same as larger screens', 'bestwebexpert' ), value: '' },
	{ label: __( 'Left', 'bestwebexpert' ), value: 'left' },
	{ label: __( 'Centre', 'bestwebexpert' ), value: 'center' },
	{ label: __( 'Right', 'bestwebexpert' ), value: 'right' },
	{ label: __( 'Spread out', 'bestwebexpert' ), value: 'between' },
];
const BLANK = { text: '', url: '', style: 'primary', newTab: false, rel: '' };

export function buttonsClasses( attributes ) {
	const { align, alignTablet, alignMobile, stackMobile, fullMobile, size } =
		attributes;
	return [
		'wp-block-buttons',
		'bwe-gw-btns',
		align && `bwe-gw-btns--${ align }`,
		alignTablet && `bwe-gw-btns--${ alignTablet }-t`,
		alignMobile && `bwe-gw-btns--${ alignMobile }-m`,
		stackMobile && 'bwe-gw-btns--stack-m',
		fullMobile && 'bwe-gw-btns--full-m',
		size && `bwe-gw-btns--${ size }`,
	]
		.filter( Boolean )
		.join( ' ' );
}

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const items = Array.isArray( attributes.items ) ? attributes.items : [];
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const update = ( index, patch ) =>
		setAttributes( {
			items: items.map( ( item, i ) =>
				i === index ? { ...item, ...patch } : item
			),
		} );
	const move = ( index, to ) => {
		if ( to < 0 || to >= items.length ) {
			return;
		}
		const next = [ ...items ];
		const [ item ] = next.splice( index, 1 );
		next.splice( to, 0, item );
		setAttributes( { items: next } );
	};
	const blockProps = useBlockProps( {
		className: [ buttonsClasses( attributes ), className ]
			.filter( Boolean )
			.join( ' ' ),
	} );
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Buttons', 'bestwebexpert' ) }>
					{ items.map( ( item, index ) => (
						<div
							key={ index }
							style={ {
								padding: 12,
								marginBottom: 12,
								border: '1px solid #e0e0e0',
								borderRadius: 4,
							} }
						>
							<p style={ { margin: '0 0 8px', fontWeight: 600 } }>
								{ sprintf(
									/* translators: %d: button number. */
									__( 'Button %d', 'bestwebexpert' ),
									index + 1
								) }
							</p>
							<TextControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __( 'Text', 'bestwebexpert' ) }
								value={ item.text || '' }
								onChange={ ( v ) =>
									update( index, { text: v } )
								}
							/>
							<TextControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __( 'Link', 'bestwebexpert' ) }
								help={ __(
									'A page (/contact/), a section (#pricing) or a full address.',
									'bestwebexpert'
								) }
								value={ item.url || '' }
								onChange={ ( v ) =>
									update( index, { url: v } )
								}
							/>
							<SelectControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __( 'Look', 'bestwebexpert' ) }
								value={ item.style || 'primary' }
								options={ LOOK_OPTIONS }
								onChange={ ( v ) =>
									update( index, { style: v } )
								}
							/>
							<ToggleControl
								__nextHasNoMarginBottom
								label={ __(
									'Open in a new tab',
									'bestwebexpert'
								) }
								checked={ !! item.newTab }
								onChange={ ( v ) =>
									update( index, { newTab: v } )
								}
							/>
							<SelectControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __(
									'Link type (SEO)',
									'bestwebexpert'
								) }
								value={ item.rel || '' }
								options={ REL_OPTIONS }
								onChange={ ( v ) =>
									update( index, { rel: v } )
								}
							/>
							<Flex style={ { marginTop: 8 } }>
								<FlexBlock>
									<Button
										size="small"
										variant="tertiary"
										disabled={ index === 0 }
										onClick={ () =>
											move( index, index - 1 )
										}
									>
										{ __( '↑ Up', 'bestwebexpert' ) }
									</Button>
									<Button
										size="small"
										variant="tertiary"
										disabled={ index === items.length - 1 }
										onClick={ () =>
											move( index, index + 1 )
										}
									>
										{ __( '↓ Down', 'bestwebexpert' ) }
									</Button>
								</FlexBlock>
								<Button
									size="small"
									variant="tertiary"
									isDestructive
									onClick={ () =>
										setAttributes( {
											items: items.filter(
												( _, i ) => i !== index
											),
										} )
									}
								>
									{ __( 'Remove', 'bestwebexpert' ) }
								</Button>
							</Flex>
						</div>
					) ) }
					{ items.length < 6 && (
						<Button
							variant="secondary"
							onClick={ () =>
								setAttributes( {
									items: [
										...items,
										{
											...BLANK,
											text: __(
												'Button',
												'bestwebexpert'
											),
											style: items.length
												? 'outline'
												: 'primary',
										},
									],
								} )
							}
						>
							{ __( '+ Add a button', 'bestwebexpert' ) }
						</Button>
					) }
				</PanelBody>
				<PanelBody
					title={ __( 'Layout on each device', 'bestwebexpert' ) }
					initialOpen={ false }
				>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Alignment', 'bestwebexpert' ) }
						value={ attributes.align }
						options={ [
							{
								label: __( 'Left (normal)', 'bestwebexpert' ),
								value: '',
							},
							...ALIGN.slice( 2 ),
						] }
						onChange={ set( 'align' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Alignment on tablet', 'bestwebexpert' ) }
						value={ attributes.alignTablet }
						options={ ALIGN }
						onChange={ set( 'alignTablet' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Alignment on phone', 'bestwebexpert' ) }
						value={ attributes.alignMobile }
						options={ ALIGN }
						onChange={ set( 'alignMobile' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Stack the buttons on phones',
							'bestwebexpert'
						) }
						checked={ !! attributes.stackMobile }
						onChange={ set( 'stackMobile' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Full-width buttons on phones',
							'bestwebexpert'
						) }
						checked={ !! attributes.fullMobile }
						onChange={ set( 'fullMobile' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Size', 'bestwebexpert' ) }
						value={ attributes.size }
						options={ [
							{
								label: __( 'Normal', 'bestwebexpert' ),
								value: '',
							},
							{
								label: __( 'Small', 'bestwebexpert' ),
								value: 'sm',
							},
							{
								label: __( 'Large', 'bestwebexpert' ),
								value: 'lg',
							},
						] }
						onChange={ set( 'size' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div { ...blockProps }>
				{ css && <style>{ css }</style> }
				{ items.map( ( item, index ) => (
					<div
						key={ index }
						className={
							'wp-block-button ' +
							( LOOKS[ item.style ] || LOOKS.primary )
						}
					>
						<RichText
							tagName="a"
							className="wp-block-button__link wp-element-button"
							value={ item.text }
							onChange={ ( v ) => update( index, { text: v } ) }
							placeholder={ __( 'Button text', 'bestwebexpert' ) }
							allowedFormats={ [ 'core/bold', 'core/italic' ] }
							disableLineBreaks
						/>
					</div>
				) ) }
				{ ! items.length && (
					<Button
						variant={ isSelected ? 'primary' : 'secondary' }
						onClick={ () =>
							setAttributes( {
								items: [
									{
										...BLANK,
										text: __(
											'Get started →',
											'bestwebexpert'
										),
										url: '/contact/',
									},
								],
							} )
						}
					>
						{ __( '+ Add a button', 'bestwebexpert' ) }
					</Button>
				) }
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
