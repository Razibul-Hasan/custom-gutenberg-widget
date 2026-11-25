import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
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

const TEMPLATE = [
	[ 'bwe/step' ],
	[ 'bwe/step' ],
	[ 'bwe/step' ],
	[ 'bwe/step' ],
];

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const blockProps = useBlockProps( {
		className: [
			'wp-block-group elementor-element elementor-element-8fdfd26 e-con-full bwex-section bwex-section--dark bwex-process e-flex e-con e-child',
			look.className,
		]
			.filter( Boolean )
			.join( ' ' ),
		'data-bwe-anchor': attributes.sectionId || undefined, // the site's #id rules (eyebrow icon …)
	} );
	const stepsProps = useInnerBlocksProps(
		{ className: 'bwex-num bwex-num--row bwex-num--dark' },
		{
			allowedBlocks: [ 'bwe/step' ],
			template: TEMPLATE,
			orientation: 'horizontal',
		}
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
				<div className="wp-block-group elementor-element elementor-element-de37328 e-con-full bwex-wrap e-flex e-con e-child">
					<HeadWidget
						attributes={ attributes }
						setAttributes={ setAttributes }
						elementId="60e9620"
						idKey="headElementId"
					/>
					<div className="wp-block-group elementor-element elementor-element-847773d elementor-widget elementor-widget-bwex-numbered-list">
						<div className="wp-block-group elementor-widget-container">
							<ol { ...stepsProps } start="1" />
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
