import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	SelectControl,
	ToggleControl,
} from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import metadata from './block.json';

// Keep in step with bwe_gw_grid_classes() (includes/generic-blocks.php).
export function gridClasses( a ) {
	const n = ( v, d ) =>
		Math.max( 1, Math.min( 6, parseInt( v ?? d, 10 ) || d ) );
	return [
		'bwe-gw-grid',
		`bwe-gw-grid--c${ n( a.columns, 3 ) }`,
		`bwe-gw-grid--t${ n( a.columnsTablet, 2 ) }`,
		`bwe-gw-grid--m${ n( a.columnsMobile, 1 ) }`,
		a.ratio && `bwe-gw-grid--r${ a.ratio }`,
		a.valign && `bwe-gw-grid--v-${ a.valign }`,
		a.cards && 'bwe-gw-grid--cards',
		a.cards && `bwe-gw-grid--cards-${ a.cards }`,
		a.reverseMobile && 'bwe-gw-grid--rev-m',
	]
		.filter( Boolean )
		.join( ' ' );
}

const card = ( title, text ) => [
	'core/group',
	{},
	[
		[ 'core/heading', { level: 3, content: title } ],
		[ 'core/paragraph', { content: text } ],
	],
];
const TEMPLATE = [
	card(
		__( 'Fast by default', 'bestwebexpert' ),
		__(
			'Pages that load in under two seconds on a phone.',
			'bestwebexpert'
		)
	),
	card(
		__( 'Built for search', 'bestwebexpert' ),
		__(
			'Clean headings, schema and internal links from day one.',
			'bestwebexpert'
		)
	),
	card(
		__( 'Easy to edit', 'bestwebexpert' ),
		__(
			'Change words, images and prices yourself, without code.',
			'bestwebexpert'
		)
	),
];

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	// The "+" appears while the grid or one of its items is selected (like core Columns), so it never takes a cell
	// in the normal view.
	const innerSelected = useSelect(
		( select ) =>
			select( 'core/block-editor' ).hasSelectedInnerBlock(
				clientId,
				true
			),
		[ clientId ]
	);
	const {
		columns,
		columnsTablet,
		columnsMobile,
		ratio,
		valign,
		cards,
		reverseMobile,
	} = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		attributes.bweStyle,
		clientId
	);
	const { children, ...props } = useInnerBlocksProps(
		useBlockProps( {
			className: [ gridClasses( attributes ), className ]
				.filter( Boolean )
				.join( ' ' ),
		} ),
		{
			template: TEMPLATE,
			templateLock: false,
			renderAppender:
				isSelected || innerSelected
					? InnerBlocks.ButtonBlockAppender
					: false,
		}
	);
	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Columns on each device', 'bestwebexpert' ) }
				>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Desktop', 'bestwebexpert' ) }
						value={ columns }
						min={ 1 }
						max={ 6 }
						onChange={ ( v ) =>
							setAttributes( { columns: v || 3 } )
						}
					/>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Tablet', 'bestwebexpert' ) }
						value={ columnsTablet }
						min={ 1 }
						max={ 6 }
						onChange={ ( v ) =>
							setAttributes( { columnsTablet: v || 2 } )
						}
					/>
					<RangeControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Phone', 'bestwebexpert' ) }
						value={ columnsMobile }
						min={ 1 }
						max={ 6 }
						onChange={ ( v ) =>
							setAttributes( { columnsMobile: v || 1 } )
						}
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Column widths (2 columns)',
							'bestwebexpert'
						) }
						help={ __(
							'Used on desktop and tablet when there are two columns, e.g. text beside a screenshot.',
							'bestwebexpert'
						) }
						value={ ratio }
						options={ [
							{
								label: __( 'Equal', 'bestwebexpert' ),
								value: '',
							},
							{
								label: __(
									'2 : 1 (wide left)',
									'bestwebexpert'
								),
								value: '2-1',
							},
							{
								label: __(
									'1 : 2 (wide right)',
									'bestwebexpert'
								),
								value: '1-2',
							},
							{
								label: __( '3 : 2', 'bestwebexpert' ),
								value: '3-2',
							},
							{
								label: __( '2 : 3', 'bestwebexpert' ),
								value: '2-3',
							},
							{
								label: __( '3 : 1', 'bestwebexpert' ),
								value: '3-1',
							},
							{
								label: __( '1 : 3', 'bestwebexpert' ),
								value: '1-3',
							},
						] }
						onChange={ set( 'ratio' ) }
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Vertical alignment', 'bestwebexpert' ) }
						value={ valign }
						options={ [
							{
								label: __(
									'Same height (stretch)',
									'bestwebexpert'
								),
								value: '',
							},
							{
								label: __( 'Top', 'bestwebexpert' ),
								value: 'start',
							},
							{
								label: __( 'Middle', 'bestwebexpert' ),
								value: 'center',
							},
							{
								label: __( 'Bottom', 'bestwebexpert' ),
								value: 'end',
							},
						] }
						onChange={ set( 'valign' ) }
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Reverse the order on phones',
							'bestwebexpert'
						) }
						help={ __(
							'e.g. show the image above the text on phones.',
							'bestwebexpert'
						) }
						checked={ !! reverseMobile }
						onChange={ set( 'reverseMobile' ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Item look', 'bestwebexpert' ) }>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Each item looks like', 'bestwebexpert' ) }
						value={ cards }
						options={ [
							{
								label: __(
									'Plain item (no box)',
									'bestwebexpert'
								),
								value: '',
							},
							{
								label: __( 'White card', 'bestwebexpert' ),
								value: 'card',
							},
							{
								label: __(
									'Soft (beige) card',
									'bestwebexpert'
								),
								value: 'soft',
							},
							{
								label: __( 'Dark card', 'bestwebexpert' ),
								value: 'dark',
							},
							{
								label: __( 'Outlined card', 'bestwebexpert' ),
								value: 'line',
							},
						] }
						onChange={ set( 'cards' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ attributes.bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div { ...props }>
				{ css && <style>{ css }</style> }
				{ children }
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
	example: {
		attributes: { columns: 3, cards: 'line' },
		innerBlocks: TEMPLATE.map( ( [ name, attrs, inner ] ) => ( {
			name,
			attributes: attrs,
			innerBlocks: inner.map( ( [ n, a ] ) => ( {
				name: n,
				attributes: a,
			} ) ),
		} ) ),
		viewportWidth: 1000,
	},
} );
