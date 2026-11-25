import { useSelect } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';

/**
 * "01", "02" … — this block's position among its siblings of the same block type (FAQ questions, steps).
 *
 * @param {string} clientId  The block's client ID.
 * @param {string} blockName Block type to count.
 * @return {string} Two-digit number, or '' while unknown.
 */
export default function useSiblingNumber( clientId, blockName ) {
	return useSelect(
		( select ) => {
			const { getBlockRootClientId, getBlockOrder, getBlockName } =
				select( blockEditorStore );
			const siblings = getBlockOrder(
				getBlockRootClientId( clientId )
			).filter( ( id ) => getBlockName( id ) === blockName );
			const index = siblings.indexOf( clientId );
			return index < 0 ? '' : String( index + 1 ).padStart( 2, '0' );
		},
		[ clientId, blockName ]
	);
}
