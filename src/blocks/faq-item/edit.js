import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	RichText,
	useBlockEditingMode,
	useBlockProps,
	useInnerBlocksProps,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';
import useSiblingNumber from '../shared/use-sibling-number';

const ANSWER_TEMPLATE = [
	[ 'core/paragraph', { placeholder: __( 'Answer…', 'bestwebexpert' ) } ],
];

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { n, question, extra } = attributes;
	const number = useSiblingNumber( clientId, 'bwe/faq-item' );
	const editable = useBlockEditingMode() === 'default';

	// Keep "01, 02 …" in order when questions are moved, added or removed — only where the FAQ itself is being
	// edited (in the page editor synced patterns are read-only; changing them there would mark them as edited).
	useEffect( () => {
		if ( editable && number && number !== n ) {
			setAttributes( { n: number } );
		}
	}, [ editable, number, n, setAttributes ] );

	// Open while the question or its answer is selected, like the core Details block.
	const isOpen = useSelect(
		( select ) =>
			select( blockEditorStore ).isBlockSelected( clientId ) ||
			select( blockEditorStore ).hasSelectedInnerBlock( clientId, true ),
		[ clientId ]
	);

	const blockProps = useBlockProps( {
		className: [
			'wp-block-details',
			'bwex-faq__item',
			extra && 'bwex-faq__item--extra',
		]
			.filter( Boolean )
			.join( ' ' ),
	} );
	const answerProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex-faq__a' },
		{ template: ANSWER_TEMPLATE }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'FAQ question', 'bestwebexpert' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __(
							'Hidden until "Show more"',
							'bestwebexpert'
						) }
						help={ __(
							'Questions after the first 6 are usually hidden behind the "Show N more" button.',
							'bestwebexpert'
						) }
						checked={ !! extra }
						onChange={ ( value ) =>
							setAttributes( { extra: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<details { ...blockProps } open={ isOpen }>
				{ /* Clicking or pressing Space in the question edits it; it must not toggle the details. */ }
				<summary
					onClick={ ( event ) => event.preventDefault() }
					onKeyUp={ ( event ) =>
						event.key === ' ' && event.preventDefault()
					}
				>
					<span className="bwex-faq__n" aria-hidden="true">
						{ n }
					</span>
					<RichText
						tagName="span"
						className="bwex-faq__q"
						value={ question }
						onChange={ ( value ) =>
							setAttributes( { question: value } )
						}
						placeholder={ __( 'Question?', 'bestwebexpert' ) }
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
						disableLineBreaks
						withoutInteractiveFormatting
					/>
					<span className="bwex-faq__icon" aria-hidden="true"></span>
				</summary>
				<div { ...answerProps } />
			</details>
		</>
	);
}
