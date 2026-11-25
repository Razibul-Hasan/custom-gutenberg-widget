import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	RichText,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	HeadWidget,
	SectionSettings,
	SectionStyles,
	useSectionLook,
} from '../shared/section-parts';
import metadata from './block.json';

// Plans, the starting-prices card and the cost explainer; each can be removed, moved or added back. A synced
// pattern (core/block) is allowed too: Home's plans are the shared "Price plans" pattern, also used on /pricing/.
const ALLOWED = [
	'bwe/plans',
	'bwe/starting-prices',
	'bwe/cost-panel',
	'core/block',
];
const TEMPLATE = [
	[
		'bwe/plans',
		{},
		[
			[ 'bwe/price-plan' ],
			[ 'bwe/price-plan', { featured: true } ],
			[ 'bwe/price-plan' ],
		],
	],
	[ 'bwe/starting-prices' ],
	[ 'bwe/cost-panel' ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element elementor-element-74d01ef e-con-full bwex-section bwex-pricing e-flex e-con e-child',
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined, // the site's #id rules (eyebrow icon …)
	} );
	const { children, ...wrapProps } = useInnerBlocksProps(
		{
			className:
				'wp-block-group elementor-element elementor-element-d60292a e-con-full bwex-wrap e-flex e-con e-child',
		},
		{ allowedBlocks: ALLOWED, template: TEMPLATE }
	);
	return (
		<>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<section { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<div { ...wrapProps }>
					<HeadWidget
						attributes={ attributes }
						setAttributes={ setAttributes }
						elementId="15dc625"
						idKey="headElementId"
					/>
					{ children }
					<RichText
						tagName="p"
						className="bwex-more wp-block-paragraph"
						value={ attributes.more }
						onChange={ ( more ) => setAttributes( { more } ) }
						placeholder={ __(
							'Note under the plans (optional)',
							'bestwebexpert'
						) }
						allowedFormats={ [
							'core/bold',
							'core/italic',
							'core/link',
						] }
					/>
				</div>
			</section>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
