/**
 * Icon picker for blocks whose icon the site draws: keep the site's icon, pick one of 2,000+ Lucide line icons
 * (same style as the site's), upload/choose an image from the Media Library, paste SVG code, or show no icon.
 * The value is the block's "bweIcon" attribute (see includes/icons.php).
 */
import { __, sprintf } from '@wordpress/i18n';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import {
	BaseControl,
	Button,
	ColorPalette,
	Modal,
	PanelBody,
	SearchControl,
	SelectControl,
	Spinner,
	TextareaControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- core blocks use the same unit input.
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';
import { useEffect, useMemo, useState } from '@wordpress/element';
import { iconUrl } from './icon-engine';

const COLORS = [
	{ name: 'Lime', color: '#c8ff3d' },
	{ name: 'Ink', color: '#0b0b0c' },
	{ name: 'White', color: '#ffffff' },
	{ name: 'Paper', color: '#f4f4f0' },
	{ name: 'Muted', color: '#9a9a92' },
];

let libraryPromise = null;
function loadLibrary() {
	if ( ! libraryPromise ) {
		const url = window.bweGw && window.bweGw.iconsUrl;
		libraryPromise = url
			? window
					.fetch( url )
					.then( ( r ) => r.json() )
					.then( ( j ) => j.icons || {} )
					.catch( () => {
						libraryPromise = null;
						return {};
					} )
			: Promise.resolve( {} );
	}
	return libraryPromise;
}

const MAX_SHOWN = 240;

function LibraryModal( { onPick, onClose, color } ) {
	const [ icons, setIcons ] = useState( null );
	const [ search, setSearch ] = useState( '' );
	useEffect( () => {
		let live = true;
		loadLibrary().then( ( list ) => live && setIcons( list ) );
		return () => {
			live = false;
		};
	}, [] );
	const found = useMemo( () => {
		if ( ! icons ) {
			return [];
		}
		const words = search
			.toLowerCase()
			.trim()
			.split( /\s+/ )
			.filter( Boolean );
		return Object.keys( icons ).filter( ( name ) => {
			const hay = name + ' ' + icons[ name ][ 1 ];
			return words.every( ( w ) => hay.includes( w ) );
		} );
	}, [ icons, search ] );
	return (
		<Modal
			title={ __( 'Icon library (Lucide)', 'bestwebexpert' ) }
			onRequestClose={ onClose }
			size="large"
		>
			<SearchControl
				__nextHasNoMarginBottom
				value={ search }
				onChange={ setSearch }
				placeholder={ __(
					'Search icons, e.g. cart, rocket, shield…',
					'bestwebexpert'
				) }
			/>
			{ ! icons && <Spinner /> }
			{ icons && (
				<p style={ { margin: '8px 0', color: '#757575' } }>
					{ found.length > MAX_SHOWN
						? sprintf(
								/* translators: 1: shown, 2: total */
								__(
									'Showing %1$d of %2$d icons, search to narrow down.',
									'bestwebexpert'
								),
								MAX_SHOWN,
								found.length
							)
						: sprintf(
								/* translators: %d: number of icons */
								__( '%d icons', 'bestwebexpert' ),
								found.length
							) }
				</p>
			) }
			<div
				style={ {
					display: 'grid',
					gridTemplateColumns: 'repeat(auto-fill, minmax(92px, 1fr))',
					gap: 8,
				} }
			>
				{ found.slice( 0, MAX_SHOWN ).map( ( name ) => (
					<Button
						key={ name }
						className="bwe-icon-pick"
						label={ name }
						showTooltip
						onClick={ () => onPick( name, icons[ name ][ 0 ] ) }
						style={ {
							height: 'auto',
							flexDirection: 'column',
							gap: 6,
							padding: '12px 4px',
							border: '1px solid #e0e0e0',
							borderRadius: 8,
							justifyContent: 'center',
						} }
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
							width="28"
							height="28"
							fill="none"
							stroke={ color || '#1e1e1e' }
							strokeWidth="1.75"
							strokeLinecap="round"
							strokeLinejoin="round"
							// Markup comes from the plugin's own bundled Lucide file, not from users.
							dangerouslySetInnerHTML={ {
								__html: icons[ name ][ 0 ],
							} }
						/>
						<span
							style={ {
								fontSize: 11,
								lineHeight: 1.2,
								maxWidth: '100%',
								overflow: 'hidden',
								textOverflow: 'ellipsis',
								whiteSpace: 'nowrap',
							} }
						>
							{ name }
						</span>
					</Button>
				) ) }
			</div>
		</Modal>
	);
}

// One line under the preview saying which icon is used.
function describe( icon ) {
	if ( ! icon.source ) {
		return __( 'The site’s own icon.', 'bestwebexpert' );
	}
	if ( icon.source === 'none' ) {
		return __( 'No icon.', 'bestwebexpert' );
	}
	if ( icon.name ) {
		return icon.name;
	}
	return icon.source === 'upload'
		? __( 'Uploaded image', 'bestwebexpert' )
		: __( 'Custom SVG', 'bestwebexpert' );
}

/**
 * @param {Object}                 props
 * @param {string}                 props.title        Panel title.
 * @param {Object}                 props.value        The bweIcon attribute.
 * @param {(icon: Object) => void} props.onChange     Receives the new bweIcon value ({} = site icon).
 * @param {string}                 props.defaultColor Line colour of library icons when none is picked.
 * @param {string}                 props.chip         Preview background (the tile behind the icon).
 */
export default function IconPanel( {
	title,
	value,
	onChange,
	defaultColor = '#c8ff3d',
	chip = '#1e1e1e',
} ) {
	const icon = value || {};
	const [ open, setOpen ] = useState( false );
	const source = icon.source || '';
	const set = ( patch ) => onChange( { ...icon, ...patch } );
	const preview = iconUrl( icon, defaultColor );
	return (
		<PanelBody
			title={ title || __( 'Icon', 'bestwebexpert' ) }
			initialOpen={ false }
		>
			<div
				style={ {
					display: 'flex',
					alignItems: 'center',
					gap: 12,
					marginBottom: 16,
				} }
			>
				<span
					aria-hidden="true"
					style={ {
						width: 44,
						height: 44,
						flex: 'none',
						borderRadius: 12,
						backgroundColor: chip,
						backgroundImage: preview || 'none',
						backgroundRepeat: 'no-repeat',
						backgroundPosition: 'center',
						backgroundSize:
							source === 'upload' ? 'contain' : '24px 24px',
					} }
				/>
				<span style={ { color: '#757575', fontSize: 12 } }>
					{ describe( icon ) }
				</span>
			</div>
			<SelectControl
				__nextHasNoMarginBottom
				__next40pxDefaultSize
				label={ __( 'Icon from', 'bestwebexpert' ) }
				value={ source }
				options={ [
					{
						label: __( 'Site icon (default)', 'bestwebexpert' ),
						value: '',
					},
					{
						label: __( 'Icon library', 'bestwebexpert' ),
						value: 'library',
					},
					{
						label: __( 'Upload / Media Library', 'bestwebexpert' ),
						value: 'upload',
					},
					{ label: __( 'SVG code', 'bestwebexpert' ), value: 'svg' },
					{ label: __( 'No icon', 'bestwebexpert' ), value: 'none' },
				] }
				onChange={ ( v ) => {
					if ( v === '' ) {
						onChange( {} );
						return;
					}
					set( { source: v } );
					if ( v === 'library' && ! icon.svg ) {
						setOpen( true );
					}
				} }
			/>
			<div style={ { height: 16 } } />
			{ source === 'library' && (
				<Button variant="secondary" onClick={ () => setOpen( true ) }>
					{ icon.name
						? __( 'Change icon…', 'bestwebexpert' )
						: __( 'Choose icon…', 'bestwebexpert' ) }
				</Button>
			) }
			{ source === 'upload' && (
				<MediaUploadCheck>
					<MediaUpload
						allowedTypes={ [ 'image' ] }
						value={ icon.id }
						onSelect={ ( media ) =>
							set( {
								url: media.url,
								id: media.id,
								name: media.title || '',
							} )
						}
						render={ ( { open: openMedia } ) => (
							<div style={ { display: 'flex', gap: 8 } }>
								<Button
									variant="secondary"
									onClick={ openMedia }
								>
									{ icon.url
										? __( 'Replace image', 'bestwebexpert' )
										: __(
												'Upload or choose image',
												'bestwebexpert'
											) }
								</Button>
							</div>
						) }
					/>
				</MediaUploadCheck>
			) }
			{ source === 'svg' && (
				<TextareaControl
					__nextHasNoMarginBottom
					label={ __( 'SVG code', 'bestwebexpert' ) }
					help={ __(
						'Paste the <svg>…</svg> code of any icon (e.g. from Font Awesome, Heroicons, Tabler or Iconify). Scripts are removed.',
						'bestwebexpert'
					) }
					value={ icon.svg || '' }
					rows={ 5 }
					onChange={ ( v ) => set( { svg: v, name: '' } ) }
				/>
			) }
			{ ( source === 'library' || source === 'svg' ) && (
				<BaseControl
					id="bwe-icon-color"
					label={ __( 'Icon colour', 'bestwebexpert' ) }
					help={
						source === 'svg'
							? __(
									'Used where the SVG says currentColor.',
									'bestwebexpert'
								)
							: undefined
					}
					__nextHasNoMarginBottom
				>
					<ColorPalette
						colors={ COLORS }
						value={ icon.color || undefined }
						onChange={ ( v ) => set( { color: v || '' } ) }
						enableAlpha
						clearable
					/>
				</BaseControl>
			) }
			{ source && source !== 'none' && (
				<UnitControl
					label={ __( 'Icon size', 'bestwebexpert' ) }
					value={ icon.size || '' }
					units={ [
						{ value: 'px', label: 'px' },
						{ value: '%', label: '%' },
					] }
					onChange={ ( v ) => set( { size: v || '' } ) }
					__next40pxDefaultSize
				/>
			) }
			{ open && (
				<LibraryModal
					color={ icon.color || undefined }
					onClose={ () => setOpen( false ) }
					onPick={ ( name, svg ) => {
						set( { source: 'library', name, svg } );
						setOpen( false );
					} }
				/>
			) }
		</PanelBody>
	);
}
