import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InspectorControls,
	RichText,
	useBlockEditingMode,
	useBlockProps,
} from '@wordpress/block-editor';
import { useEffect } from '@wordpress/element';
import useSiblingNumber from '../shared/use-sibling-number';
import IconPanel from '../shared/icon-control';
import { iconCss } from '../shared/icon-engine';
import metadata from './block.json';

function Edit( { attributes, setAttributes, clientId } ) {
	const { n, title, text, reveal, bweIcon } = attributes;
	// The step's icon tile (site CSS: the step's ::after).
	const icon = iconCss( bweIcon, '::after', clientId, '#0b0d0c' );
	const number = useSiblingNumber( clientId, 'bwe/step' );
	const editable = useBlockEditingMode() === 'default';

	// Keep 01, 02 … in order when steps move (only where the steps themselves are being edited, see faq-item).
	useEffect( () => {
		if ( editable && number && number !== n ) {
			setAttributes( { n: number } );
		}
	}, [ editable, number, n, setAttributes ] );

	return (
		<li
			{ ...useBlockProps( {
				className: [
					'bwex-num__item',
					reveal && 'bwex-reveal',
					icon.className,
				]
					.filter( Boolean )
					.join( ' ' ),
			} ) }
		>
			<InspectorControls>
				<IconPanel
					title={ __( 'Icon', 'bestwebexpert' ) }
					value={ bweIcon }
					onChange={ ( v ) => setAttributes( { bweIcon: v } ) }
					defaultColor="#0b0d0c"
					chip="#ecfcc4"
				/>
			</InspectorControls>
			{ icon.css && <style>{ icon.css }</style> }
			<span className="bwex-num__n" aria-hidden="true">
				{ n }
			</span>
			<div className="bwex-num__body">
				<RichText
					tagName="h3"
					className="bwex-num__title"
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					placeholder={ __( 'Step title', 'bestwebexpert' ) }
					allowedFormats={ [ 'core/italic' ] }
					disableLineBreaks
				/>
				<div className="bwex-num__text">
					<RichText
						tagName="p"
						value={ text }
						onChange={ ( value ) =>
							setAttributes( { text: value } )
						}
						placeholder={ __(
							'A short line about this step.',
							'bestwebexpert'
						) }
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
					/>
				</div>
			</div>
		</li>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
