/**
 * "Items per row" panel (Settings sidebar) for every block that holds a row of items — plans, services, platform
 * cards, products, testimonials, steps, spec / why-us cards, who cards, starting prices, the cost panel and price
 * cards: how many items share a row on desktop, tablet and phone, "all on one row" on desktop, and "+ Add item".
 * Selecting the Pricing section works too: the panel then edits its Price plans.
 *
 * It writes the blocks' own style settings (bweStyle: columns, columnsTablet, columnsMobile, oneRow — CSS from each
 * block.json's bweStyleMap), so pages that already set columns in the Styles tab keep them, and the Styles tab no
 * longer shows those keys twice.
 */
import { __, _n, sprintf } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import {
	createBlock,
	createBlocksFromInnerBlocksTemplate,
	store as blocksStore,
} from '@wordpress/blocks';
import { store as blockEditorStore } from '@wordpress/block-editor';
import { Button, PanelBody, SelectControl } from '@wordpress/components';

// Container => the item block "+ Add item" inserts (null: items are edited in the block's own list panel).
export const ROW_BLOCKS = {
	'bwe/plans': 'bwe/price-plan',
	'bwe/services': 'bwe/service-tile',
	'bwe/platforms': 'bwe/platform-card',
	'bwe/products': 'bwe/product-card',
	'bwe/testimonials': 'bwe/video-card',
	'bwe/process': 'bwe/step',
	'bwe/steps': 'bwe/step',
	'bwe/why-us': 'bwe/spec-card',
	'bwe/spec-list': 'bwe/spec-card',
	'bwe/who-list': 'bwe/who-card',
	'bwe/price-section': 'bwe/price-card',
	'bwe/starting-prices': null,
	'bwe/cost-panel': null,
};
// Section blocks whose items sit in an inner container: the panel edits that container.
const PROXY = { 'bwe/pricing': 'bwe/plans' };
export const ROW_KEYS = [
	'columns',
	'columnsTablet',
	'columnsMobile',
	'oneRow',
];

// Every block's style map, by block name (block.json files are part of the editor bundle anyway).
const MAPS = {};
const ctx = require.context( '../', true, /^\.\/[a-z0-9-]+\/block\.json$/ );
ctx.keys().forEach( ( key ) => {
	const json = ctx( key );
	MAPS[ json.name ] = json.bweStyleMap || [];
} );

/**
 * Whether a block gets the panel (itself, or for its inner container).
 *
 * @param {string} name Block name.
 */
export const hasRowPanel = ( name ) => name in ROW_BLOCKS || name in PROXY;

const DEVICES = [
	[ 'columns', __( 'Desktop', 'bestwebexpert' ) ],
	[ 'columnsTablet', __( 'Tablet', 'bestwebexpert' ) ],
	[ 'columnsMobile', __( 'Phone', 'bestwebexpert' ) ],
];

/**
 * Options of one device's select: site default, the counts the block allows, and "all on one row" on desktop.
 *
 * @param {Object}  setting The bweStyleMap entry.
 * @param {boolean} oneRow  Offer "All on one row".
 */
function options( setting, oneRow ) {
	const list = [
		{ label: __( 'Site default', 'bestwebexpert' ), value: '' },
	];
	if ( setting.control === 'select' ) {
		setting.options.forEach( ( o ) =>
			list.push( {
				/* translators: %s: number of items in a row. */
				label: sprintf( __( '%s per row', 'bestwebexpert' ), o.value ),
				value: String( o.value ),
			} )
		);
	} else {
		for ( let n = setting.min || 1; n <= ( setting.max || 4 ); n++ ) {
			list.push( {
				label: sprintf(
					/* translators: %d: number of items in a row. */
					_n( '%d per row', '%d per row', n, 'bestwebexpert' ),
					n
				),
				value: String( n ),
			} );
		}
	}
	if ( oneRow ) {
		list.push( {
			label: __( 'All on one row (while they fit)', 'bestwebexpert' ),
			value: 'row',
		} );
	}
	return list;
}

export function RowPanel( { name, clientId } ) {
	// The block itself, or (Pricing) its inner container — as a client ID string, so the selector result is stable.
	const targetId = useSelect(
		( select ) => {
			if ( name in ROW_BLOCKS ) {
				return clientId;
			}
			const store = select( blockEditorStore );
			return (
				store
					.getBlockOrder( clientId )
					.find(
						( id ) => store.getBlockName( id ) === PROXY[ name ]
					) || ''
			);
		},
		[ clientId, name ]
	);
	if ( ! targetId ) {
		return null;
	}
	return (
		<RowSettings
			id={ targetId }
			name={ name in ROW_BLOCKS ? name : PROXY[ name ] }
		/>
	);
}

function RowSettings( { id, name } ) {
	const child = ROW_BLOCKS[ name ];
	const style =
		useSelect(
			( select ) =>
				select( blockEditorStore ).getBlockAttributes( id )?.bweStyle,
			[ id ]
		) || {};
	const count = useSelect(
		( select ) => {
			const store = select( blockEditorStore );
			return child
				? store.getBlockOrder( id ).length
				: ( store.getBlockAttributes( id )?.items || [] ).length;
		},
		[ id, child ]
	);
	const variation = useSelect(
		( select ) =>
			child
				? select( blocksStore ).getDefaultBlockVariation(
						child,
						'inserter'
					)
				: null,
		[ child ]
	);
	const { updateBlockAttributes, insertBlock } =
		useDispatch( blockEditorStore );
	const map = MAPS[ name ] || [];
	const byKey = Object.fromEntries( map.map( ( s ) => [ s.key, s ] ) );
	const save = ( changes ) => {
		const next = { ...style, ...changes };
		Object.keys( next ).forEach(
			( k ) =>
				( next[ k ] === '' || next[ k ] === undefined ) &&
				delete next[ k ]
		);
		updateBlockAttributes( id, { bweStyle: next } );
	};
	const addItem = () => {
		const block = createBlock(
			child,
			{ ...( variation?.attributes || {} ) },
			createBlocksFromInnerBlocksTemplate( variation?.innerBlocks || [] )
		);
		insertBlock( block, count, id, false );
	};
	return (
		<PanelBody title={ __( 'Items per row', 'bestwebexpert' ) }>
			{ count > 0 && (
				<p style={ { marginTop: 0, color: '#757575' } }>
					{ sprintf(
						/* translators: %d: number of items. */
						_n( '%d item', '%d items', count, 'bestwebexpert' ),
						count
					) }
				</p>
			) }
			{ DEVICES.filter( ( [ key ] ) => byKey[ key ] ).map(
				( [ key, label ] ) => {
					const desktop = key === 'columns';
					const value =
						desktop && style.oneRow
							? 'row'
							: String( style[ key ] ?? '' );
					return (
						<SelectControl
							key={ key }
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={ label }
							value={ value }
							options={ options(
								byKey[ key ],
								desktop && !! byKey.oneRow
							) }
							onChange={ ( v ) =>
								desktop
									? save( {
											columns: v === 'row' ? '' : v,
											oneRow: v === 'row' ? true : '',
										} )
									: save( { [ key ]: v } )
							}
						/>
					);
				}
			) }
			<p
				style={ {
					margin: '8px 0 12px',
					color: '#757575',
					fontSize: 12,
				} }
			>
				{ __(
					'Site default = the layout this section already has. "All on one row" puts every item side by side on desktop; only if an item would get narrower than 200px does the row wrap, so nothing sticks out.',
					'bestwebexpert'
				) }
			</p>
			{ child && (
				<Button variant="secondary" onClick={ addItem }>
					{ __( '+ Add item', 'bestwebexpert' ) }
				</Button>
			) }
		</PanelBody>
	);
}
