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

// Used only when the block has no projects yet (the inserter starter fills it with real projects).
const TEMPLATE = [ [ 'bwe/work-item' ], [ 'bwe/work-item' ] ];

function Edit( { attributes, setAttributes, clientId } ) {
	const look = useSectionLook( metadata, attributes, clientId );
	const blockProps = useBlockProps( {
		className: [ 'wp-block-group', attributes.wrapClasses, look.className ]
			.filter( Boolean )
			.join( ' ' ),
	} );
	const listProps = useInnerBlocksProps(
		{ className: 'wp-block-group bwex-work__grid' },
		{ allowedBlocks: [ 'bwe/work-item' ], template: TEMPLATE }
	);
	return (
		<>
			<SectionSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			></SectionSettings>
			<SectionStyles
				metadata={ metadata }
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div { ...blockProps }>
				{ look.css && <style>{ look.css }</style> }
				<div className="wp-block-group elementor-widget-container">
					<div className="wp-block-group bwex bwex-workw">
						<section
							className="wp-block-group bwex-section bwex-work"
							data-bwe-anchor={
								attributes.sectionId || undefined
							}
						>
							<div className="wp-block-group bwex-wrap">
								<HeadWidget
									attributes={ attributes }
									setAttributes={ setAttributes }
								/>
								<div { ...listProps } />
							</div>
						</section>
					</div>
				</div>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
} );
