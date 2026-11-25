/**
 * Page settings → "Page layout" (pages only): which wrappers the site prints around the page's sections, and the
 * structured data the page gets (includes/page-layout.php). Replaces the wrapper groups with classes that pages
 * used to keep in their content.
 *
 * The canvas also gets the layout's scope classes (the site's section CSS is scoped to them: ".bwe-sec …",
 * ".bwe-prx …"), so the sections look the same while editing as on the site.
 */
import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import {
	PluginDocumentSettingPanel,
	store as editorStore,
} from '@wordpress/editor';
import { SelectControl } from '@wordpress/components';
import { useDispatch, useSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';

const DATA = window.bweGwPageLayout || { layouts: [], schemas: [] };

/**
 * Adds the layout's scope classes to the canvas root (and keeps them there: the editor rewrites the root's class
 * attribute, e.g. on a Desktop / Tablet / Mobile switch).
 *
 * @param {string} classes Space-separated classes ('' = none).
 */
function useCanvasScope( classes ) {
	useEffect( () => {
		const list = classes ? classes.split( ' ' ) : [];
		const all = DATA.layouts.flatMap( ( l ) =>
			l.canvas ? l.canvas.split( ' ' ) : []
		);
		const apply = () => {
			document.querySelectorAll( 'iframe' ).forEach( ( frame ) => {
				let doc;
				try {
					doc = frame.contentDocument;
				} catch {
					return;
				}
				const root = doc && doc.querySelector( '.is-root-container' );
				if (
					! root ||
					! doc.body.classList.contains( 'post-type-page' )
				) {
					return;
				}
				all.forEach( ( c ) => {
					if ( ! list.includes( c ) && root.dataset.bweLayout ) {
						root.classList.remove( c );
					}
				} );
				list.forEach( ( c ) => root.classList.add( c ) );
				root.dataset.bweLayout = classes;
			} );
		};
		apply();
		const timer = setInterval( apply, 700 );
		return () => clearInterval( timer );
	}, [ classes ] );
}

function PageLayoutPanel() {
	const { type, meta } = useSelect( ( select ) => {
		const editor = select( editorStore );
		return {
			type: editor.getCurrentPostType(),
			meta: editor.getEditedPostAttribute( 'meta' ) || {},
		};
	}, [] );
	const { editPost } = useDispatch( editorStore );
	const layout = meta.bwe_page_layout || '';
	const current = DATA.layouts.find( ( l ) => l.value === layout );
	useCanvasScope( type === 'page' && current ? current.canvas : '' );
	if ( type !== 'page' || meta.bwe_page_layout === undefined ) {
		return null;
	}
	const set = ( key ) => ( value ) =>
		editPost( { meta: { ...meta, [ key ]: value } } );
	return (
		<PluginDocumentSettingPanel
			name="bwe-page-layout"
			title={ __( 'Page layout', 'bestwebexpert' ) }
		>
			<SelectControl
				__nextHasNoMarginBottom
				__next40pxDefaultSize
				label={ __( 'Section wrappers', 'bestwebexpert' ) }
				help={ __(
					'How the site wraps this page’s sections. “Automatic” is how Home and new pages work.',
					'bestwebexpert'
				) }
				value={ layout }
				options={ [
					{ label: __( 'Automatic', 'bestwebexpert' ), value: '' },
					...DATA.layouts.map( ( l ) => ( {
						label: l.label,
						value: l.value,
					} ) ),
				] }
				onChange={ set( 'bwe_page_layout' ) }
			/>
			{ !! layout && (
				<SelectControl
					__nextHasNoMarginBottom
					__next40pxDefaultSize
					label={ __( 'Structured data (schema)', 'bestwebexpert' ) }
					value={ meta.bwe_page_schema || '' }
					options={ [
						{ label: __( 'None', 'bestwebexpert' ), value: '' },
						...DATA.schemas.map( ( s ) => ( {
							label: s.label,
							value: s.value,
						} ) ),
					] }
					onChange={ set( 'bwe_page_schema' ) }
				/>
			) }
		</PluginDocumentSettingPanel>
	);
}

registerPlugin( 'bwe-page-layout', { render: PageLayoutPanel } );
