import { styleCss } from './style-engine';

/**
 * Editor side of a block's style settings: a scope class for this block and its CSS ('' when nothing is set).
 *
 * @param {Array}  map      The block's bweStyleMap.
 * @param {Object} values   The bweStyle attribute.
 * @param {string} clientId Block client ID.
 * @return {{className: string, css: string}} Scope class and CSS.
 */
export default function useBlockStyle( map, values, clientId ) {
	const className = 'bwe-s-e' + clientId.replace( /-/g, '' ).slice( 0, 10 );
	const css = styleCss( map, values, className );
	return { className: css ? className : '', css };
}
