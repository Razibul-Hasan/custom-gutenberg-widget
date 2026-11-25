import { __, sprintf } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import {
	AttrText,
	AttrToggle,
	HeadWidget,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import metadata from './block.json';

const TEMPLATE = [ [ 'bwe/faq-item' ], [ 'bwe/faq-item' ], [ 'bwe/faq-item' ] ];

function Edit( { attributes, setAttributes, clientId } ) {
	const { askText, showAsk, toggleText } = attributes;
	const look = useSectionLook( metadata, attributes, clientId );
	// How many questions wait behind "Show N more" (each question's own setting).
	const hidden = useSelect(
		( select ) =>
			select( blockEditorStore )
				.getBlocks( clientId )
				.filter(
					( b ) => b.name === 'bwe/faq-item' && b.attributes.extra
				).length,
		[ clientId ]
	);
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element elementor-element-bfd7b46 e-con-full bwex-section bwex-faq-section e-flex e-con e-child',
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined, // the site's #id rules (eyebrow icon …)
	} );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex-faq' },
		{ allowedBlocks: [ 'bwe/faq-item' ], template: TEMPLATE }
	);
	const label = (
		toggleText ||
		( hidden === 1 ? 'Show {n} more question' : 'Show {n} more questions' )
	).replace( '{n}', hidden );
	const props = { attributes, setAttributes };
	return (
		<>
			<SectionSettings { ...props }>
				<AttrToggle
					label={ __(
						'Show the "ask a question" button',
						'bestwebexpert'
					) }
					name="showAsk"
					{ ...props }
				/>
				{ showAsk !== false && (
					<>
						<AttrText
							label={ __( 'Ask button link', 'bestwebexpert' ) }
							name="askUrl"
							{ ...props }
						/>
						<AttrToggle
							label={ __(
								'Open the ask button in a new tab',
								'bestwebexpert'
							) }
							name="askNewTab"
							{ ...props }
						/>
					</>
				) }
				<AttrText
					label={ __( '"Show more" button text', 'bestwebexpert' ) }
					help={ sprintf(
						/* translators: %d: hidden questions. */
						__(
							'Shown when questions are set to "Hidden until Show more" (now: %d). {n} = how many. Empty = "Show {n} more questions".',
							'bestwebexpert'
						),
						hidden
					) }
					name="toggleText"
					{ ...props }
				/>
				<AttrText
					label={ __( 'Question list ID (for links, optional)',
						'bestwebexpert'
					) }
					name="listId"
					{ ...props }
				/>
			</SectionSettings>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-element elementor-element-4652c6c e-con-full bwex-wrap e-flex e-con e-child">
					<div className="wp-block-group elementor-element elementor-element-17f5218 e-con-full bwex-faq__grid e-flex e-con e-child">
						<div className="wp-block-group elementor-element elementor-element-9e568fa e-con-full bwex-faq__intro e-flex e-con e-child">
							<HeadWidget
								attributes={ attributes }
								setAttributes={ setAttributes }
								elementId="b4093ad"
								idKey="headElementId"
							/>
							{ showAsk !== false && (
								<div className="elementor-element elementor-element-90a6427 bwex-btn elementor-widget elementor-widget-button">
									{ /* eslint-disable-next-line jsx-a11y/anchor-is-valid -- no href while editing (it can't navigate); the link is edited in the sidebar. */ }
									<a className="elementor-button elementor-button-link elementor-size-sm">
										<span className="elementor-button-content-wrapper">
											<RichText
												tagName="span"
												className="elementor-button-text"
												value={ askText }
												onChange={ ( v ) =>
													setAttributes( {
														askText: v,
													} )
												}
												placeholder={ __(
													'Button text',
													'bestwebexpert'
												) }
												allowedFormats={ [] }
												disableLineBreaks
											/>
										</span>
									</a>
								</div>
							) }
						</div>
						<div className="wp-block-group elementor-element elementor-element-5eb4cba elementor-widget elementor-widget-bwex-faq">
							<div className="wp-block-group elementor-widget-container">
								<div { ...listProps } />
								{ hidden > 0 && (
									<button
										type="button"
										className="bwex-faq__toggle"
										disabled
									>
										{ label }
									</button>
								) }
							</div>
						</div>
					</div>
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
