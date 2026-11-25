/**
 * Editor side of includes/global-controls.php — settings every bwe/* block has:
 * - "Visibility": hide on desktop / tablet / phone (a hidden block stays editable here, only faded);
 * - "Heading tag (SEO)": the tag of the block's main heading (h1–h6, p, div …); the look stays the same.
 * The attributes come from PHP (register_block_type_args), so blocks need no changes of their own.
 * Loaded by every block bundle through style-panels.js; the flag below makes it register once.
 */
import { __, sprintf } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { RowPanel, hasRowPanel } from './row-controls';

// Keep in step with BWE_GW_HEADING_BLOCKS (includes/global-controls.php): block => normal tag.
export const HEADING_BLOCKS = {
	'bwe/hero': 'h1',
	'bwe/section-head': 'h2',
	'bwe/services': 'h2',
	'bwe/why-us': 'h2',
	'bwe/testimonials': 'h2',
	'bwe/pricing': 'h2',
	'bwe/process': 'h2',
	'bwe/products': 'h2',
	'bwe/faq': 'h2',
	'bwe/price-section': 'h2',
	'bwe/work': 'h2',
	'bwe/about': 'h2',
	'bwe/contact-form': 'h2',
	'bwe/cta': 'h2',
	'bwe/step': 'h3',
	'bwe/price-plan': 'h3',
	'bwe/price-card': 'h3',
	'bwe/platform-card': 'h3',
	'bwe/product-card': 'h3',
	'bwe/work-item': 'h3',
	'bwe/cost-panel': 'h3',
	'bwe/spec-card': 'strong',
};

const TAG_LABELS = {
	h1: __( 'H1 — the page’s main heading (one per page)', 'bestwebexpert' ),
	h2: __( 'H2 — section heading', 'bestwebexpert' ),
	h3: __( 'H3 — sub-heading / card title', 'bestwebexpert' ),
	h4: __( 'H4', 'bestwebexpert' ),
	h5: __( 'H5', 'bestwebexpert' ),
	h6: __( 'H6', 'bestwebexpert' ),
	p: __( 'Paragraph (not a heading)', 'bestwebexpert' ),
	div: __( 'Div (not a heading)', 'bestwebexpert' ),
	span: __( 'Span (not a heading)', 'bestwebexpert' ),
	strong: __( 'Strong (bold text, not a heading)', 'bestwebexpert' ),
};

const DEVICES = [
	[ 'desktop', __( 'Hide on desktop (1025px and wider)', 'bestwebexpert' ) ],
	[ 'tablet', __( 'Hide on tablet (782–1024px)', 'bestwebexpert' ) ],
	[ 'mobile', __( 'Hide on phone (781px and narrower)', 'bestwebexpert' ) ],
];

export function hideClasses( hide ) {
	const h = hide || {};
	return [
		h.desktop && 'bwe-hide-d',
		h.tablet && 'bwe-hide-t',
		h.mobile && 'bwe-hide-m',
	]
		.filter( Boolean )
		.join( ' ' );
}

const withGlobalControls = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		const { name, attributes, setAttributes, isSelected, clientId } = props;
		if ( ! String( name ).startsWith( 'bwe/' ) || attributes.bwePreview ) {
			return <BlockEdit { ...props } />;
		}
		const normal = HEADING_BLOCKS[ name ];
		const hide = attributes.bweHide || {};
		const options = normal
			? [
					{
						label: sprintf(
							/* translators: %s: the block's normal heading tag, e.g. H2. */
							__( 'Default (%s)', 'bestwebexpert' ),
							normal.toUpperCase()
						),
						value: '',
					},
					...Object.keys( TAG_LABELS )
						.filter(
							( t ) =>
								t !== normal &&
								( t !== 'strong' || normal === 'strong' )
						)
						.map( ( t ) => ( {
							label: TAG_LABELS[ t ],
							value: t,
						} ) ),
				]
			: [];
		return (
			<>
				<BlockEdit { ...props } />
				{ isSelected && (
					<InspectorControls>
						{ hasRowPanel( name ) && (
							<RowPanel name={ name } clientId={ clientId } />
						) }
						{ normal && (
							<PanelBody
								title={ __(
									'Heading tag (SEO)',
									'bestwebexpert'
								) }
								initialOpen={ false }
							>
								<SelectControl
									__nextHasNoMarginBottom
									__next40pxDefaultSize
									label={ __(
										'Main heading is printed as',
										'bestwebexpert'
									) }
									help={ __(
										'Changes only the HTML tag, not the look. Use one H1 per page, H2 for sections, H3 for cards inside a section.',
										'bestwebexpert'
									) }
									value={ attributes.headingTag || '' }
									options={ options }
									onChange={ ( v ) =>
										setAttributes( { headingTag: v } )
									}
								/>
							</PanelBody>
						) }
						<PanelBody
							title={ __( 'Visibility', 'bestwebexpert' ) }
							initialOpen={ false }
						>
							{ DEVICES.map( ( [ device, label ] ) => (
								<ToggleControl
									key={ device }
									__nextHasNoMarginBottom
									label={ label }
									checked={ !! hide[ device ] }
									onChange={ ( on ) => {
										const next = {
											...hide,
											[ device ]: on,
										};
										if ( ! on ) {
											delete next[ device ];
										}
										setAttributes( { bweHide: next } );
									} }
								/>
							) ) }
						</PanelBody>
					</InspectorControls>
				) }
			</>
		);
	},
	'withBweGlobalControls'
);

// The block's wrapper in the canvas gets the hide classes: blocks.css fades it on the hidden device sizes.
const withHideClasses = createHigherOrderComponent(
	( BlockListBlock ) => ( props ) => {
		const cls = String( props.name ).startsWith( 'bwe/' )
			? hideClasses( props.attributes?.bweHide )
			: '';
		if ( ! cls ) {
			return <BlockListBlock { ...props } />;
		}
		return (
			<BlockListBlock
				{ ...props }
				className={ [ props.className, cls ]
					.filter( Boolean )
					.join( ' ' ) }
			/>
		);
	},
	'withBweHideClasses'
);

if ( typeof window !== 'undefined' && ! window.bweGwGlobalControls ) {
	window.bweGwGlobalControls = true;
	addFilter(
		'editor.BlockEdit',
		'bestwebexpert/global-controls',
		withGlobalControls
	);
	addFilter(
		'editor.BlockListBlock',
		'bestwebexpert/hide-classes',
		withHideClasses
	);
}
