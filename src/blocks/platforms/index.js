import { __ } from '@wordpress/i18n';
import { createBlock, registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	store as blockEditorStore,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { Button, PanelBody, ToggleControl } from '@wordpress/components';
import { useDispatch, useSelect } from '@wordpress/data';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import PARTS from '../../../includes/parts.json';
import metadata from './block.json';

// The cards' feature list: the site's checkmark list, as a role (no CSS class).
const CHECKS = Object.keys( PARTS ).find(
	( k ) =>
		PARTS[ k ].block === 'core/list' && PARTS[ k ].classes === 'bwex-checks'
);

// What a new pack starts with (all of it is editable on the card).
export const NEW_CARD = [
	'bwe/platform-card',
	{
		chip: 'New',
		title: 'New package',
		text: 'One or two lines about this package, in plain words.',
		price: 'Starting at <strong>$0</strong>',
		btnText: 'See pricing →',
		btnUrl: '/pricing/',
	},
	[
		[
			'core/list',
			{ bwePart: CHECKS },
			[
				[ 'core/list-item', { content: 'First service' } ],
				[ 'core/list-item', { content: 'Second service' } ],
			],
		],
	],
];

function Edit( { attributes, setAttributes, clientId, isSelected } ) {
	const { classes, bweStyle } = attributes;
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		bweStyle,
		clientId
	);
	const { count, childSelected } = useSelect(
		( select ) => ( {
			count: select( blockEditorStore ).getBlockCount( clientId ),
			childSelected: select( blockEditorStore ).hasSelectedInnerBlock(
				clientId,
				true
			),
		} ),
		[ clientId ]
	);
	const { insertBlock } = useDispatch( blockEditorStore );
	const addCard = () => {
		const [ name, attrs, inner ] = NEW_CARD;
		const toBlocks = ( list ) =>
			list.map( ( [ n, a, children ] ) =>
				createBlock( n, a, children ? toBlocks( children ) : [] )
			);
		insertBlock(
			createBlock( name, attrs, toBlocks( inner ) ),
			count,
			clientId
		);
	};
	const innerBlocksProps = useInnerBlocksProps(
		useBlockProps( {
			className: [ 'wp-block-group', classes, className ]
				.filter( Boolean )
				.join( ' ' ),
		} ),
		{
			allowedBlocks: [ 'bwe/platform-card' ],
			template: [ NEW_CARD, NEW_CARD ],
			orientation: 'horizontal',
			renderAppender: false,
		}
	);
	const { children, ...gridProps } = innerBlocksProps;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Cards', 'bestwebexpert' ) }>
					<p>
						{ count === 1
							? __( '1 card.', 'bestwebexpert' )
							: `${ count } ${ __( 'cards.', 'bestwebexpert' ) }` }{ ' ' }
						{ __(
							'Select a card to edit its image, links and badge; drag or use the arrows to reorder.',
							'bestwebexpert'
						) }
					</p>
					<Button variant="primary" onClick={ addCard }>
						{ __( '+ Add a card (new pack)', 'bestwebexpert' ) }
					</Button>
				</PanelBody>
				<PanelBody title={ __( 'Layout', 'bestwebexpert' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Three cards per row (wide screens)',
							'bestwebexpert'
						) }
						checked={ ` ${ classes } `.includes(
							' bwex-plats--3 '
						) }
						onChange={ ( on ) =>
							setAttributes( {
								classes: on
									? String( classes )
											.replace(
												'bwex-plats ',
												'bwex-plats bwex-plats--3 '
											)
											.replace(
												'bwex-plats--3 bwex-plats--3 ',
												'bwex-plats--3 '
											)
									: String( classes ).replace(
											' bwex-plats--3',
											''
										),
							} )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<div { ...gridProps }>
				{ css && <style>{ css }</style> }
				{ children }
				{ ( isSelected || childSelected ) && (
					<div
						style={ {
							display: 'flex',
							alignItems: 'center',
							justifyContent: 'center',
							minHeight: 160,
							border: '1px dashed #c8c8c0',
							borderRadius: 20,
						} }
					>
						<Button variant="secondary" onClick={ addCard }>
							{ __( '+ Add a card (new pack)', 'bestwebexpert' ) }
						</Button>
					</div>
				) }
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
