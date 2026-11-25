import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import StylePanels from '../shared/style-panels';
import useBlockStyle from '../shared/use-block-style';
import IconPanel from '../shared/icon-control';
import { iconCss } from '../shared/icon-engine';
import { withRoles } from '../shared/part-controls';
import metadata from './block.json';
import variations from './variations';

const TAGS = [
	{
		label: __( 'section (a page section — normal)', 'bestwebexpert' ),
		value: 'section',
	},
	{ label: __( 'div (plain box)', 'bestwebexpert' ), value: 'div' },
	{
		label: __( 'aside (side note, demo bar)', 'bestwebexpert' ),
		value: 'aside',
	},
	{
		label: __( 'article (stands on its own)', 'bestwebexpert' ),
		value: 'article',
	},
	{ label: __( 'header', 'bestwebexpert' ), value: 'header' },
	{ label: __( 'footer', 'bestwebexpert' ), value: 'footer' },
	{
		label: __( 'main (the page’s main content)', 'bestwebexpert' ),
		value: 'main',
	},
	{ label: __( 'nav (links)', 'bestwebexpert' ), value: 'nav' },
];

// A new Section starts with the site's section layout (content wrap, eyebrow + heading + intro, text, button), so
// it looks like the other sections right away and every Styles setting has something to act on. Sections that
// already have content keep it (a template only fills an empty block).
const TEMPLATE = withRoles( [
	[
		'core/group',
		{ className: 'bwex-wrap', metadata: { name: 'Content' } },
		[
			[
				'bwe/section-head',
				{
					eyebrow: __( 'Small label', 'bestwebexpert' ),
					title: __(
						'Section heading with a <em>highlight</em>',
						'bestwebexpert'
					),
					intro: __(
						'A short intro line that says what this section is about.',
						'bestwebexpert'
					),
				},
			],
			[
				'core/paragraph',
				{
					placeholder: __(
						'Add text, images, columns or any other block…',
						'bestwebexpert'
					),
				},
			],
			[
				'core/buttons',
				{},
				[
					[
						'core/button',
						{
							className: 'bwe-btn bwe-btn--primary',
							text: __( 'Get started →', 'bestwebexpert' ),
						},
					],
				],
			],
		],
	],
] );

// Section look = one of the site's section modifiers, kept in the "classes" attribute.
const TONES = [
	{ label: __( 'White', 'bestwebexpert' ), value: '' },
	{
		label: __( 'Soft (light beige)', 'bestwebexpert' ),
		value: 'bwex-section--soft',
	},
	{
		label: __( 'Dark (grid, like "How it works")', 'bestwebexpert' ),
		value: 'bwe-gw-tone--dark',
	},
];
// Section layout = the site's section markup for that kind of section (the classes its CSS is written for; the
// Elementor ids are part of it). Picked here instead of typing classes; the Section style (tone) is kept.
const LAYOUTS = [
	{
		label: __( 'Plain section', 'bestwebexpert' ),
		value: 'plain',
		classes: 'bwex-section',
	},
	{
		label: __( 'Long text (legal page, article)', 'bestwebexpert' ),
		value: 'prose',
		classes: 'bwex-section bwex-prose',
		token: 'bwex-prose',
	},
	{
		label: __( 'Showcase (live demo)', 'bestwebexpert' ),
		value: 'showcase',
		classes: 'bwex-section bwex-showcase',
		token: 'bwex-showcase',
	},
	{
		label: __( 'Showcase — text beside the demo', 'bestwebexpert' ),
		value: 'showcase-side',
		classes: 'bwex-section bwex-showcase bwex-showcase--side',
		token: 'bwex-showcase--side',
	},
	{
		label: __( 'Showcase — dark', 'bestwebexpert' ),
		value: 'showcase-dark',
		classes: 'bwex-section bwex-showcase bwex-showcase--dark',
		token: 'bwex-showcase--dark',
	},
	{
		label: __( 'Text + image', 'bestwebexpert' ),
		value: 'split',
		classes: 'bwex-section bwex-split',
		token: 'bwex-split',
	},
	{
		label: __( 'Big screenshot', 'bestwebexpert' ),
		value: 'media',
		classes: 'bwex-section bwex-media',
		token: 'bwex-media',
	},
	{
		label: __( 'Guide with contents', 'bestwebexpert' ),
		value: 'guide',
		classes: 'bwex-section bwex-guide',
		token: 'bwex-guide',
	},
	{
		label: __( 'Screenshot tour', 'bestwebexpert' ),
		value: 'tour',
		classes: 'bwex-section bwex-tour-section',
		token: 'bwex-tour-section',
	},
	{
		label: __( 'Spec cards', 'bestwebexpert' ),
		value: 'spec',
		classes: 'bwex-section bwex-spec',
		token: 'bwex-spec',
	},
	{
		label: __( 'About (text + card)', 'bestwebexpert' ),
		value: 'about',
		classes:
			'elementor-element elementor-element-84190b5 e-con-full bwex-section bwex-about e-flex e-con e-child',
		token: 'bwex-about',
	},
	{
		label: __( 'Who we build for', 'bestwebexpert' ),
		value: 'who',
		classes:
			'elementor-element elementor-element-1eb77b6 e-con-full bwex-section bwex-who e-flex e-con e-child',
		token: 'bwex-who',
	},
	{
		label: __( 'Platform cards', 'bestwebexpert' ),
		value: 'services',
		classes:
			'elementor-element elementor-element-0334ad8 e-con-full bwex-section bwex-services e-flex e-con e-child',
		token: 'bwex-services',
	},
	{
		label: __( 'Pricing', 'bestwebexpert' ),
		value: 'pricing',
		classes:
			'elementor-element elementor-element-74d01ef e-con-full bwex-section bwex-pricing e-flex e-con e-child',
		token: 'bwex-pricing',
	},
	{
		label: __( 'FAQ', 'bestwebexpert' ),
		value: 'faq',
		classes:
			'elementor-element elementor-element-bfd7b46 e-con-full bwex-section bwex-faq-section e-flex e-con e-child',
		token: 'bwex-faq-section',
	},
	{
		label: __( 'How it works (dark)', 'bestwebexpert' ),
		value: 'process',
		classes:
			'elementor-element elementor-element-8fdfd26 e-con-full bwex-section bwex-section--dark bwex-process e-flex e-con e-child',
		token: 'bwex-process',
	},
	{
		label: __( 'Call to action box', 'bestwebexpert' ),
		value: 'cta',
		classes: 'bwe-section bwe-final',
		token: 'bwe-final',
	},
];
const has = ( classes, token ) =>
	` ${ classes || '' } `.includes( ` ${ token } ` );
const layoutOf = ( classes ) =>
	(
		LAYOUTS.find(
			( l ) =>
				l.token && has( classes, l.token ) && l.token.includes( '--' )
		) ||
		LAYOUTS.find( ( l ) => l.token && has( classes, l.token ) ) ||
		LAYOUTS[ 0 ]
	).value;

const toneOf = ( classes ) =>
	(
		TONES.find(
			( t ) => t.value && ` ${ classes } `.includes( ` ${ t.value } ` )
		) || TONES[ 0 ]
	).value;
const withTone = ( classes, tone ) =>
	[
		...String( classes || '' )
			.split( /\s+/ )
			.filter( ( c ) => c && ! TONES.some( ( t ) => t.value === c ) ),
		tone,
	]
		.filter( Boolean )
		.join( ' ' );

function Edit( { attributes, setAttributes, clientId } ) {
	const { classes, bweStyle, bweIcon, tagName } = attributes;
	const Tag = TAGS.some( ( t ) => t.value === tagName ) ? tagName : 'section';
	const { className, css } = useBlockStyle(
		metadata.bweStyleMap,
		bweStyle,
		clientId
	);
	// The eyebrow's icon tile (site CSS: the label's ::before).
	const icon = iconCss(
		bweIcon,
		' :is(.bwex-eyebrow p, p.bwe-eyebrow)::before',
		clientId,
		'#0b0b0c'
	);
	// Same <section> as on the site; its content stays normal, editable blocks.
	const innerBlocksProps = useInnerBlocksProps(
		useBlockProps( {
			className: [ 'wp-block-group', classes, className, icon.className ]
				.filter( Boolean )
				.join( ' ' ),
		} ),
		{ templateLock: false, template: TEMPLATE }
	);
	const { children, ...sectionProps } = innerBlocksProps;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section', 'bestwebexpert' ) }>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Background', 'bestwebexpert' ) }
						value={ toneOf( classes ) }
						options={ TONES }
						onChange={ ( tone ) =>
							setAttributes( {
								classes: withTone( classes, tone ),
							} )
						}
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'HTML tag (SEO)', 'bestwebexpert' ) }
						help={ __(
							'Only changes the tag, not the look.',
							'bestwebexpert'
						) }
						value={ Tag }
						options={ TAGS }
						onChange={ ( value ) =>
							setAttributes( { tagName: value } )
						}
					/>
					<SelectControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Layout', 'bestwebexpert' ) }
						help={ __(
							'Which kind of section this is: the site styles each kind its own way.',
							'bestwebexpert'
						) }
						value={ layoutOf( classes ) }
						options={ LAYOUTS.map( ( l ) => ( {
							label: l.label,
							value: l.value,
						} ) ) }
						onChange={ ( value ) =>
							setAttributes( {
								classes: withTone(
									LAYOUTS.find( ( l ) => l.value === value )
										.classes,
									toneOf( classes )
								),
							} )
						}
					/>
				</PanelBody>
				<IconPanel
					title={ __( 'Small label icon', 'bestwebexpert' ) }
					value={ bweIcon }
					onChange={ ( v ) => setAttributes( { bweIcon: v } ) }
					defaultColor="#0b0b0c"
					chip="#c8ff3d"
				/>
			</InspectorControls>
			<StylePanels
				map={ metadata.bweStyleMap }
				values={ bweStyle }
				onChange={ ( v ) => setAttributes( { bweStyle: v } ) }
			/>
			<Tag { ...sectionProps }>
				{ css && <style>{ css }</style> }
				{ icon.css && <style>{ icon.css }</style> }
				{ children }
			</Tag>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => <InnerBlocks.Content />,
	variations,
} );
