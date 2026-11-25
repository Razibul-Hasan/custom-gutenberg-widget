/**
 * Shared editor parts of the Home section blocks (Why us, Testimonials, Pricing, How it works, Our products, FAQ,
 * Call to action): the header (eyebrow / heading / intro), the "Section" settings panel, the eyebrow icon and a
 * small list editor for array attributes (price rows, cost points). The markup matches the blocks' render.php.
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	RichText,
	useBlockEditContext,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import {
	Button,
	Flex,
	FlexBlock,
	PanelBody,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import StylePanels from './style-panels';
import useBlockStyle from './use-block-style';
import IconPanel from './icon-control';
import { iconCss } from './icon-engine';

export const INLINE = [ 'core/bold', 'core/italic', 'core/link' ];

/**
 * Style + eyebrow-icon CSS of a section block.
 *
 * @param {Object} metadata   block.json.
 * @param {Object} attributes Block attributes.
 * @param {string} clientId   Block client ID.
 * @param {string} iconPart   Where the eyebrow icon is drawn ('' = none).
 * @return {{className: string, css: string}} Scope classes and CSS.
 */
export function useSectionLook(
	metadata,
	attributes,
	clientId,
	iconPart = ' .bwex-eyebrow p::before'
) {
	const style = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const icon = iconPart
		? iconCss( attributes.bweIcon, iconPart, clientId, '#0b0b0c' )
		: { className: '', css: '' };
	return {
		className: [ style.className, icon.className ]
			.filter( Boolean )
			.join( ' ' ),
		css: ( style.css || '' ) + ( icon.css || '' ),
	};
}

/**
 * The Styles tab + eyebrow icon panel of a section block.
 *
 * @param {Object}   props
 * @param {Object}   props.metadata      block.json.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 * @param {boolean}  props.icon          Show the eyebrow icon panel.
 */
export function SectionStyles( {
	metadata,
	attributes,
	setAttributes,
	icon = true,
} ) {
	return (
		<>
			{ icon && (
				<InspectorControls>
					<IconPanel
						title={ __( 'Small label icon', 'bestwebexpert' ) }
						value={ attributes.bweIcon }
						onChange={ ( v ) => setAttributes( { bweIcon: v } ) }
						defaultColor="#0b0b0c"
						chip="#c8ff3d"
					/>
				</InspectorControls>
			) }
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
		</>
	);
}

/**
 * "Section" settings panel: ID, header parts and any block-specific controls (children).
 *
 * @param {Object}   props
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 * @param {boolean}  props.head          Show the header toggles.
 * @param {Object}   props.children      Extra controls.
 */
export function SectionSettings( {
	attributes,
	setAttributes,
	head = true,
	children,
} ) {
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	return (
		<InspectorControls>
			<PanelBody title={ __( 'Section', 'bestwebexpert' ) }>
				<TextControl
					__nextHasNoMarginBottom
					__next40pxDefaultSize
					label={ __(
						'Section ID (for links like #pricing)',
						'bestwebexpert'
					) }
					value={ attributes.sectionId || '' }
					onChange={ set( 'sectionId' ) }
				/>
				{ head && (
					<>
						<ToggleControl
							__nextHasNoMarginBottom
							label={ __( 'Show the small label above the heading', 'bestwebexpert' ) }
							checked={ attributes.showEyebrow !== false }
							onChange={ set( 'showEyebrow' ) }
						/>
						{ attributes.showIntro !== undefined && (
							<ToggleControl
								__nextHasNoMarginBottom
								label={ __(
									'Show the intro text',
									'bestwebexpert'
								) }
								checked={ attributes.showIntro !== false }
								onChange={ set( 'showIntro' ) }
							/>
						) }
						{ attributes.split !== undefined && (
							<ToggleControl
								__nextHasNoMarginBottom
								label={ __(
									'Intro beside the heading (wide screens)',
									'bestwebexpert'
								) }
								checked={ !! attributes.split }
								onChange={ set( 'split' ) }
							/>
						) }
					</>
				) }
				{ head && attributes.headingId !== undefined && (
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Heading ID (for links like #care-plans)',
							'bestwebexpert'
						) }
						value={ attributes.headingId || '' }
						onChange={ set( 'headingId' ) }
					/>
				) }
				{ children }
			</PanelBody>
		</InspectorControls>
	);
}

/**
 * Section header as the site prints it (bwe_gw_head()).
 *
 * @param {Object}   props
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 * @param {boolean}  props.headw         Wrapped in .bwex.bwex-headw.
 */
export function SectionHead( { attributes, setAttributes, headw = true } ) {
	const { eyebrow, title, intro, split, showEyebrow, showIntro } = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	// The site leaves an empty intro out; here its field shows only while the block is being edited.
	const { clientId } = useBlockEditContext();
	const editing = useSelect(
		( select ) => {
			const store = select( 'core/block-editor' );
			return (
				!! clientId &&
				( store.isBlockSelected( clientId ) ||
					store.hasSelectedInnerBlock( clientId, true ) )
			);
		},
		[ clientId ]
	);
	const head = (
		<div
			className={
				'wp-block-group bwex-head' +
				( split ? ' bwex-head--split' : '' )
			}
		>
			<div className="wp-block-group bwex-head__main">
				{ showEyebrow !== false && (
					<div className="wp-block-group bwex-eyebrow">
						<RichText
							tagName="p"
							className="wp-block-paragraph"
							value={ eyebrow }
							onChange={ set( 'eyebrow' ) }
							placeholder={ __( 'Small label', 'bestwebexpert' ) }
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
							'Heading — make words italic to highlight them',
							'bestwebexpert'
						) }
						allowedFormats={ [ 'core/italic' ] }
					/>
				</div>
			</div>
			{ showIntro !== false && ( editing || !! intro ) && (
				<div className="wp-block-group bwex-intro">
					<RichText
						tagName="p"
						className="wp-block-paragraph"
						value={ intro }
						onChange={ set( 'intro' ) }
						placeholder={ __(
							'Intro text (optional)',
							'bestwebexpert'
						) }
						allowedFormats={ INLINE }
					/>
				</div>
			) }
		</div>
	);
	return headw ? (
		<div className="wp-block-group bwex bwex-headw">{ head }</div>
	) : (
		head
	);
}

/**
 * The section header inside the section-head widget wrapper (the site's bwe_gw_head_widget()).
 *
 * @param {Object}   props
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 * @param {string}   props.elementId     Elementor id of the wrapper ('' = none).
 * @param {string}   props.idKey         Attribute that can change the id ('' = fixed).
 */
export function HeadWidget( {
	attributes,
	setAttributes,
	elementId = '',
	idKey = '',
} ) {
	const id = idKey ? ( attributes[ idKey ] ?? elementId ) : elementId;
	return (
		<div
			className={
				'wp-block-group elementor-element ' +
				( id ? `elementor-element-${ id } ` : '' ) +
				'elementor-widget elementor-widget-bwex-section-head'
			}
		>
			<div className="wp-block-group elementor-widget-container">
				<SectionHead
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
			</div>
		</div>
	);
}

/**
 * A text field bound to one attribute.
 *
 * @param {Object}   props
 * @param {string}   props.label         Label.
 * @param {string}   props.name          Attribute.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 * @param {string}   props.help          Help text.
 */
export function AttrText( { label, name, attributes, setAttributes, help } ) {
	return (
		<TextControl
			__nextHasNoMarginBottom
			__next40pxDefaultSize
			label={ label }
			help={ help }
			value={ attributes[ name ] || '' }
			onChange={ ( value ) => setAttributes( { [ name ]: value } ) }
		/>
	);
}

/**
 * A toggle bound to one boolean attribute.
 *
 * @param {Object}   props
 * @param {string}   props.label         Label.
 * @param {string}   props.name          Attribute.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Setter.
 */
export function AttrToggle( { label, name, attributes, setAttributes } ) {
	return (
		<ToggleControl
			__nextHasNoMarginBottom
			label={ label }
			checked={ attributes[ name ] !== false }
			onChange={ ( value ) => setAttributes( { [ name ]: value } ) }
		/>
	);
}

/**
 * Sidebar editor for an array attribute: one box per item with its fields, move up / down, remove, and add.
 *
 * @param {Object}   props
 * @param {string}   props.title    Panel title.
 * @param {Array}    props.items    Items.
 * @param {Array}    props.fields   [{ key, label }] text fields of an item.
 * @param {Object}   props.blank    A new item.
 * @param {string}   props.addLabel Add button label.
 * @param {Function} props.onChange Receives the new items.
 */
export function ItemsPanel( {
	title,
	items,
	fields,
	blank,
	addLabel,
	onChange,
} ) {
	const list = Array.isArray( items ) ? items : [];
	const update = ( index, key, value ) =>
		onChange(
			list.map( ( item, i ) =>
				i === index ? { ...item, [ key ]: value } : item
			)
		);
	const move = ( index, to ) => {
		if ( to < 0 || to >= list.length ) {
			return;
		}
		const next = [ ...list ];
		const [ item ] = next.splice( index, 1 );
		next.splice( to, 0, item );
		onChange( next );
	};
	return (
		<PanelBody title={ title }>
			{ list.map( ( item, index ) => (
				<div
					key={ index }
					style={ {
						padding: 12,
						marginBottom: 12,
						border: '1px solid #e0e0e0',
						borderRadius: 4,
					} }
				>
					{ fields.map( ( field ) => (
						<div key={ field.key } style={ { marginBottom: 8 } }>
							<TextControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ field.label }
								value={ item[ field.key ] || '' }
								onChange={ ( value ) =>
									update( index, field.key, value )
								}
							/>
						</div>
					) ) }
					<Flex>
						<FlexBlock>
							<Button
								size="small"
								variant="tertiary"
								disabled={ index === 0 }
								onClick={ () => move( index, index - 1 ) }
							>
								{ __( '↑ Up', 'bestwebexpert' ) }
							</Button>
							<Button
								size="small"
								variant="tertiary"
								disabled={ index === list.length - 1 }
								onClick={ () => move( index, index + 1 ) }
							>
								{ __( '↓ Down', 'bestwebexpert' ) }
							</Button>
						</FlexBlock>
						<Button
							size="small"
							variant="tertiary"
							isDestructive
							onClick={ () =>
								onChange(
									list.filter( ( _, i ) => i !== index )
								)
							}
						>
							{ __( 'Remove', 'bestwebexpert' ) }
						</Button>
					</Flex>
				</div>
			) ) }
			<Button
				variant="secondary"
				onClick={ () => onChange( [ ...list, { ...blank } ] ) }
			>
				{ addLabel }
			</Button>
		</PanelBody>
	);
}
