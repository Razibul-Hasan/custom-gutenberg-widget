/**
 * The Styles tab for blocks with a "bweStyleMap": one panel per group, one control per setting, a reset per
 * panel. Values are saved in the block's "bweStyle" attribute; empty = the site's normal style.
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	useBlockEditContext,
} from '@wordpress/block-editor';
import {
	BaseControl,
	Button,
	ColorPalette,
	PanelBody,
	RangeControl,
	SelectControl,
	ToggleControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- core blocks use the same unit input.
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';
import styleLabel from './style-labels';
import './global-controls';
import { ROW_BLOCKS, ROW_KEYS } from './row-controls';

// The site's colours first, so the brand look is one click away.
const COLORS = [
	{ name: 'Lime', color: '#c8ff3d' },
	{ name: 'Ink', color: '#0b0b0c' },
	{ name: 'Night', color: '#111111' },
	{ name: 'Paper', color: '#f4f4f0' },
	{ name: 'White', color: '#ffffff' },
	{ name: 'Muted', color: '#9a9a92' },
];

const UNITS = [ 'px', 'rem', 'em', 'vh', 'vw', '%' ].map( ( value ) => ( {
	value,
	label: value,
} ) );

function Control( { setting, value, onChange } ) {
	const label = styleLabel( setting.label );
	switch ( setting.control ) {
		case 'color':
			return (
				<BaseControl
					id={ `bwe-style-${ setting.key }` }
					label={ label }
					__nextHasNoMarginBottom
				>
					<ColorPalette
						colors={ COLORS }
						value={ value || undefined }
						onChange={ ( v ) => onChange( v || '' ) }
						enableAlpha
						clearable
					/>
				</BaseControl>
			);
		case 'unit':
			return (
				<UnitControl
					label={ label }
					value={ value || '' }
					units={ UNITS }
					onChange={ ( v ) => onChange( v || '' ) }
					__next40pxDefaultSize
				/>
			);
		case 'range':
			return (
				<RangeControl
					label={ label }
					value={
						value === '' || value === undefined
							? undefined
							: Number( value )
					}
					min={ setting.min }
					max={ setting.max }
					step={ setting.step || 1 }
					allowReset
					onChange={ ( v ) =>
						onChange(
							v === undefined || v === null ? '' : String( v )
						)
					}
					__nextHasNoMarginBottom
					__next40pxDefaultSize
				/>
			);
		case 'select':
			return (
				<SelectControl
					label={ label }
					value={ value || '' }
					options={ [
						{ label: __( 'Default', 'bestwebexpert' ), value: '' },
						...setting.options.map( ( o ) => ( {
							...o,
							label: styleLabel( o.label ),
						} ) ),
					] }
					onChange={ ( v ) => onChange( v ) }
					__nextHasNoMarginBottom
					__next40pxDefaultSize
				/>
			);
		case 'toggle':
			return (
				<ToggleControl
					label={ label }
					checked={ !! value }
					onChange={ ( v ) => onChange( v ? true : '' ) }
					__nextHasNoMarginBottom
				/>
			);
		case 'image':
			return (
				<BaseControl
					id={ `bwe-style-${ setting.key }` }
					label={ label }
					__nextHasNoMarginBottom
				>
					<MediaUploadCheck>
						<MediaUpload
							allowedTypes={ [ 'image' ] }
							onSelect={ ( media ) => onChange( media.url ) }
							render={ ( { open } ) => (
								<div
									style={ {
										display: 'flex',
										gap: 8,
										alignItems: 'center',
									} }
								>
									{ value && (
										<img
											src={ value }
											alt=""
											style={ {
												width: 48,
												height: 32,
												objectFit: 'cover',
												borderRadius: 4,
											} }
										/>
									) }
									<Button
										variant="secondary"
										onClick={ open }
									>
										{ value
											? __( 'Replace', 'bestwebexpert' )
											: __(
													'Choose image',
													'bestwebexpert'
												) }
									</Button>
									{ value && (
										<Button
											variant="tertiary"
											isDestructive
											onClick={ () => onChange( '' ) }
										>
											{ __( 'Remove', 'bestwebexpert' ) }
										</Button>
									) }
								</div>
							) }
						/>
					</MediaUploadCheck>
				</BaseControl>
			);
		default:
			return null;
	}
}

export default function StylePanels( { map, values, onChange } ) {
	const current = values || {};
	const set = ( key, value ) => {
		const next = { ...current, [ key ]: value };
		if ( value === '' || value === undefined || value === null ) {
			delete next[ key ];
		}
		onChange( next );
	};
	const panels = [];
	// Row counts live in the Settings sidebar (Items per row) for blocks that hold a row of items.
	const { name } = useBlockEditContext();
	const rows = name in ROW_BLOCKS;
	( map || [] ).forEach( ( setting ) => {
		if ( rows && ROW_KEYS.includes( setting.key ) ) {
			return;
		}
		let panel = panels.find( ( p ) => p.name === setting.panel );
		if ( ! panel ) {
			panel = { name: setting.panel, settings: [] };
			panels.push( panel );
		}
		panel.settings.push( setting );
	} );
	return (
		<InspectorControls group="styles">
			{ panels.map( ( panel, index ) => {
				const used = panel.settings.filter(
					( s ) => current[ s.key ] !== undefined
				);
				return (
					<PanelBody
						key={ panel.name }
						title={ styleLabel( panel.name ) }
						initialOpen={ index === 0 }
					>
						{ panel.settings.map( ( setting ) => (
							<div
								key={ setting.key }
								style={ { marginBottom: 16 } }
							>
								<Control
									setting={ setting }
									value={ current[ setting.key ] }
									onChange={ ( v ) => set( setting.key, v ) }
								/>
							</div>
						) ) }
						{ used.length > 0 && (
							<Button
								variant="secondary"
								onClick={ () => {
									const next = { ...current };
									used.forEach(
										( s ) => delete next[ s.key ]
									);
									onChange( next );
								} }
							>
								{ __( 'Reset this panel', 'bestwebexpert' ) }
							</Button>
						) }
					</PanelBody>
				);
			} ) }
		</InspectorControls>
	);
}
