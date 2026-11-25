/**
 * "Section part" (Settings tab) for the core blocks inside our sections: paragraph, heading, list, list item, image,
 * buttons, button, table and group. The role is a named part of the site's section markup (includes/parts.json:
 * "Guide chapter › Chapter number", "About section › Card" …) and gives the block exactly the classes that part needs,
 * so nothing goes into Advanced → "Additional CSS class(es)" and no custom CSS is needed.
 * - saved markup: the role's classes are added to the block's HTML (the HTML the site's CSS and scripts expect);
 * - editor: the same classes on the block, so it looks like the site while editing;
 * - site: includes/parts.php hands the classes to the PHP code that reads a block's classes while rendering.
 */
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import PARTS from '../../../includes/parts.json';

export const PART_BLOCKS = [
	'core/group',
	'core/paragraph',
	'core/heading',
	'core/list',
	'core/list-item',
	'core/image',
	'core/buttons',
	'core/button',
	'core/table',
];

const partOf = ( name, attributes ) => {
	const part =
		attributes && attributes.bwePart && PARTS[ attributes.bwePart ];
	return part && part.block === name ? part : null;
};

/**
 * A block template with the site's part classes given as roles: [ name, { className: 'bwex-checks' } ] becomes
 * [ name, { bwePart: '…' } ], so blocks inserted from our templates and layouts never carry CSS classes.
 *
 * @param {Array} template Block template.
 * @return {Array} The same template with roles.
 */
export function withRoles( template ) {
	return ( template || [] ).map( ( [ name, attrs = {}, inner = [] ] ) => {
		const { className, ...rest } = attrs;
		const key =
			className &&
			Object.keys( PARTS ).find(
				( k ) =>
					PARTS[ k ].block === name &&
					PARTS[ k ].classes === className
			);
		const next = key ? { bwePart: key, ...rest } : attrs;
		return [ name, next, withRoles( inner ) ];
	} );
}

const join = ( ...list ) => list.filter( Boolean ).join( ' ' );

addFilter(
	'blocks.registerBlockType',
	'bwe/part-attribute',
	( settings, name ) =>
		PART_BLOCKS.includes( name )
			? {
					...settings,
					attributes: {
						...settings.attributes,
						bwePart: { type: 'string' },
					},
				}
			: settings
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'bwe/part-save',
	( props, blockType, attributes ) => {
		const part = partOf( blockType.name, attributes );
		return part
			? { ...props, className: join( props.className, part.classes ) }
			: props;
	}
);

addFilter(
	'editor.BlockListBlock',
	'bwe/part-editor-class',
	createHigherOrderComponent(
		( BlockListBlock ) => ( props ) => {
			const part = partOf( props.name, props.attributes );
			return part ? (
				<BlockListBlock
					{ ...props }
					className={ join( props.className, part.classes ) }
				/>
			) : (
				<BlockListBlock { ...props } />
			);
		},
		'withBwePartClass'
	)
);

/**
 * The role picker: the roles for this block type, grouped by section.
 *
 * @param {Object}   props
 * @param {string}   props.name     Block name.
 * @param {string}   props.value    Current role.
 * @param {Function} props.onChange Setter.
 */
function PartSelect( { name, value, onChange } ) {
	const groups = {};
	Object.entries( PARTS ).forEach( ( [ key, part ] ) => {
		if ( part.block === name ) {
			groups[ part.context ] = groups[ part.context ] || [];
			groups[ part.context ].push( [ key, part.label ] );
		}
	} );
	const order = Object.keys( groups ).sort( ( a, b ) => {
		if ( a === 'General' ) {
			return -1;
		}
		return b === 'General' ? 1 : a.localeCompare( b );
	} );
	return (
		<SelectControl
			__nextHasNoMarginBottom
			__next40pxDefaultSize
			label={ __( 'Role in the section', 'bestwebexpert' ) }
			help={ __(
				'Gives this block the look of that part of the site’s sections. No CSS classes needed.',
				'bestwebexpert'
			) }
			value={ value || '' }
			onChange={ ( v ) => onChange( v || undefined ) }
		>
			<option value="">
				{ __( 'None (plain block)', 'bestwebexpert' ) }
			</option>
			{ order.map( ( ctx ) => (
				<optgroup key={ ctx } label={ ctx }>
					{ groups[ ctx ].map( ( [ key, label ] ) => (
						<option key={ key } value={ key }>
							{ label }
						</option>
					) ) }
				</optgroup>
			) ) }
		</SelectControl>
	);
}

addFilter(
	'editor.BlockEdit',
	'bwe/part-controls',
	createHigherOrderComponent(
		( BlockEdit ) => ( props ) => {
			const { name, attributes, setAttributes, clientId, isSelected } =
				props;
			const supported = PART_BLOCKS.includes( name );
			// Shown inside our widgets / sections, and wherever a role is already set.
			const inside = useSelect(
				( select ) => {
					if ( ! supported || ! isSelected ) {
						return false;
					}
					const store = select( 'core/block-editor' );
					return store
						.getBlockParents( clientId )
						.some( ( id ) =>
							String( store.getBlockName( id ) || '' ).startsWith(
								'bwe/'
							)
						);
				},
				[ supported, clientId, isSelected ]
			);
			if (
				! supported ||
				! isSelected ||
				( ! inside && ! attributes.bwePart )
			) {
				return <BlockEdit { ...props } />;
			}
			return (
				<>
					<BlockEdit { ...props } />
					<InspectorControls>
						<PanelBody
							title={ __( 'Section part', 'bestwebexpert' ) }
						>
							<PartSelect
								name={ name }
								value={ attributes.bwePart }
								onChange={ ( bwePart ) =>
									setAttributes( { bwePart } )
								}
							/>
						</PanelBody>
					</InspectorControls>
				</>
			);
		},
		'withBwePartControls'
	)
);
